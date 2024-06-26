from fastapi import Response, HTTPException
from models.userData import UserData
from models.daymenu import DayMenu
from models.recipe import Recipe
from schemas.Daymenu import daymenuEntity, daymenusEntity
from bson.objectid import ObjectId
from starlette.status import HTTP_204_NO_CONTENT 

import random
from dotenv import load_dotenv

import os
import httpx
import json



load_dotenv()
API_ID = os.getenv("EDAMAM_API_ID")
API_KEY = os.getenv("EDAMAM_API_KEY")
DBM_NAME = os.getenv("DBM_NAME")



def index(db, skip: int = 0, limit: int = 100):
    db = getattr(db, DBM_NAME)
    return daymenusEntity(db.daymenus.find())

def show(db, daymenu_id: str):
    db = getattr(db, DBM_NAME)
    return daymenuEntity(db.daymenus.find_one({"_id": ObjectId(daymenu_id)}))

def store(db, daymenu: DayMenu):
    db = getattr(db, DBM_NAME)
    new_daymenu = dict(daymenu)
    recipes_dict = []
    for recipe in new_daymenu["recipes"]:
        recipes_dict.append(dict(recipe))

    new_daymenu["recipes"] = recipes_dict
    id = db.daymenus.insert_one(new_daymenu).inserted_id
    db_daymenu = daymenuEntity(db.daymenus.find_one({"_id": ObjectId(id)}))
    return db_daymenu


def update(db, daymenu_id: str, daymenu: DayMenu):
    db = getattr(db, DBM_NAME)
    db_daymenu = daymenuEntity(db.daymenus.find_one_and_update({"_id": ObjectId(daymenu_id)}, {"$set": dict(daymenu)}, return_document=True))

    return db_daymenu

def delete(db, daymenu_id: str):
    db = getattr(db, DBM_NAME)
    daymenuEntity(db.daymenus.find_one_and_delete({"_id": ObjectId(daymenu_id)}))
    return Response(status_code=HTTP_204_NO_CONTENT)

async def generate_day_menu(userData: UserData):
    try:
        url = "https://api.edamam.com/api/recipes/v2"

        userData = dict(userData)
        params = {
            "type": "public",
            "beta": "false",
            "app_id": API_ID,
            "app_key": API_KEY,
            "field": [
                "label",
                "dietLabels",
                "healthLabels",
                "mealType",
                "dishType",
                "cautions",
                "ingredientLines",
                "calories",
                "glycemicIndex",
                "inflammatoryIndex",
                "totalTime",
            ]
        }
        for key, value in userData.items():
            if value != None:
                if key == "nutrients":
                    for nut_key, nut_value in value.items():
                        if '%2B'in nut_value or '-' in nut_value:
                            params[f"{key}%5B{nut_key}%5D"] = f"{nut_value}"
                elif key == "query":
                    params["q"] = value
                else:
                    params[key] = value

        meal_types = ["breakfast", "lunch", "dinner"]
        day_menu = DayMenu(recipes=[], total_calories=0, total_nutrients=0)
        for meal in meal_types:
            params["mealType"] = meal

            async with httpx.AsyncClient() as client:
                response = await client.get(url, params=params)

            if response.status_code == 200:
                data = dict(response.json())
                response = data["hits"]
                if len(response) == 0:
                    response = {"message": "No se encontraron recetas con los parámetros proporcionados"}
                else:
                    response= random.choice(response)
                    recipe = Recipe.from_dict(response["recipe"])

                    day_menu.recipes.append(recipe)
                
                    day_menu.total_calories += recipe.calories
                
            else:
                raise HTTPException(status_code=response.status_code, detail=response.json())
        return day_menu
       
    except httpx.HTTPError as err:
        raise HTTPException(status_code=500, detail=str(err))

