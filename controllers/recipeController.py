from sqlalchemy.orm import Session
from dotenv import load_dotenv
import httpx
import os

from models import models, schemas

load_dotenv()
API_ID = os.getenv("EDADMAM_API_ID")
API_KEY = os.getenv("EDADMAM_API_KEY")


def index(db: Session, skip: int = 0, limit: int = 100):
    return db.query(models.Recipe).offset(skip).limit(limit).all()

def show(db: Session, recipe_id: int):
    return db.query(models.Recipe).filter(models.Recipe.id == recipe_id).first()

def create(db: Session, recipe: schemas.Recipe):
    db_recipe = recipe.Recipe(title=recipe.title, description=recipe.description)
    db.add(db_recipe)
    db.commit()
    db.refresh(db_recipe)
    return db_recipe

def update(db: Session, recipe_id: int, recipe: schemas.Recipe):
    db_recipe = db.query(recipe.Recipe).filter(recipe.Recipe.id == recipe_id).first()
    db_recipe.title = recipe.title
    db_recipe.description = recipe.description
    db.commit()
    db.refresh(db_recipe)
    return db_recipe

def delete(db: Session, recipe_id: int):
    db_recipe = db.query(models.Recipe).filter(models.Recipe.id == recipe_id).first()
    db.delete(db_recipe)
    db.commit()
    return db_recipe

""" def get_recipe_from_api(q: str, f: int, to: int, diet: str, health: str, r: str, calories: str, returns: str, callback: str):
    url = "https://api.edamam.com/search?"

    request_url = httpx.get(url, params={"q": "chicken", "app_id": API_ID, "app_key": API_KEY}) """