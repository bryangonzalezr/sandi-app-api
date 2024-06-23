from fastapi import Response, HTTPException
from dotenv import load_dotenv
from starlette.status import HTTP_204_NO_CONTENT
from bson.objectid import ObjectId
import httpx
import os
import json

from models.recipe import Recipe
from models.userData import UserData
from schemas.recipe import recipeEntity, recipesEntity
import random

load_dotenv()
API_ID = os.getenv("EDAMAM_API_ID")
API_KEY = os.getenv("EDAMAM_API_KEY")
DBM_NAME = os.getenv("DBM_NAME")



def index(db, skip: int = 0, limit: int = 100):
    db = getattr(db, DBM_NAME)
    return recipesEntity(db.recipes.find())

def show(db, recipe_id: str):
    db = getattr(db, DBM_NAME)
    return recipeEntity(db.recipes.find_one({"_id": ObjectId(recipe_id)}))

def store(db, recipe: Recipe):
    db = getattr(db, DBM_NAME)
    new_recipe = dict(recipe)
    id = db.recipes.insert_one(new_recipe).inserted_id
    db_recipe = recipeEntity(db.recipes.find_one({"_id": ObjectId(id)}))
    return db_recipe

def update(db, recipe_id: str, recipe: Recipe):
    db = getattr(db, DBM_NAME)
    db_recipe = recipeEntity(db.recipes.find_one_and_update({"_id": ObjectId(recipe_id)}, {"$set": dict(recipe)}, return_document=True))

    return db_recipe

def delete(db, recipe_id: str):
    db = getattr(db, DBM_NAME)
    recipeEntity(db.recipes.find_one_and_delete({"_id": ObjectId(recipe_id)}))
    return Response(status_code=HTTP_204_NO_CONTENT)

async def getRecipeFromApi(userData: UserData):
    try:
        url = "https://api.edamam.com/api/recipes/v2"

        userData = dict(userData)
        params = {
            "type": "public",
            "beta": "false",
            "app_id": API_ID,
            "app_key": API_KEY
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

        async with httpx.AsyncClient() as client:
            response = await client.get(url, params=params)

        if response.status_code == 200:
            data = dict(response.json())
            response = data.get("hits")
            
            if len(response) == 0:
                recipe = {"message": "No se encontraron recetas con los parámetros proporcionados"}
            else:
                response= random.choice(response)
                recipe = Recipe.from_dict(response["recipe"])
            

            return recipe
        else:
            raise HTTPException(status_code=response.status_code, detail=response.json())
    except httpx.HTTPError as err:
        raise HTTPException(status_code=500, detail=str(err))
    