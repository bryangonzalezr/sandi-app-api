from fastapi import Response
from dotenv import load_dotenv
from starlette.status import HTTP_204_NO_CONTENT
import httpx
import os

from models.recipe import Recipe
from schemas.recipe import recipeEntity, recipesEntity

load_dotenv()
API_ID = os.getenv("EDADMAM_API_ID")
API_KEY = os.getenv("EDADMAM_API_KEY")
DBM_NAME = os.getenv("DBM_NAME")



def index(db, skip: int = 0, limit: int = 100):
    db = getattr(db, DBM_NAME)
    return recipesEntity(db.recipes.find())

def show(db, recipe_id: int):
    db = getattr(db, DBM_NAME)
    return recipeEntity(db.recipes.find_one({"_id": recipe_id}))

def store(db, recipe: Recipe):
    db = getattr(db, DBM_NAME)
    new_recipe = dict(recipe)
    id = db.recipes.insert_one(new_recipe).inserted_id
    db_recipe = recipeEntity(db.recipes.find_one({"_id": id}))
    return db_recipe

def update(db, recipe_id: int, recipe: Recipe):
    db = getattr(db, DBM_NAME)
    db_recipe = recipeEntity(db.recipes.find_one_and_update({"_id": recipe_id}, {"$set": dict(recipe)}, return_document=True))

    return db_recipe

def delete(db, recipe_id: int):
    db = getattr(db, DBM_NAME)
    recipeEntity(db.recipes.find_one_and_delete({"_id": recipe_id}))
    return Response(status_code=HTTP_204_NO_CONTENT)

""" def get_recipe_from_api(q: str, f: int, to: int, diet: str, health: str, r: str, calories: str, returns: str, callback: str):
    url = "https://api.edamam.com/recipes/v2?"

    request_url = httpx.get(url, params={"q": "chicken", "app_id": API_ID, "app_key": API_KEY}) """