from fastapi import APIRouter, Depends
from sqlalchemy.orm import Session

from models.recipe import Recipe
from controllers import recipeController
from database.database import SessionLocal, engine
from database.mongo import conn as mongodb

#models.Base.metadata.create_all(bind=engine)

recipe = APIRouter()

# Dependency
""" def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close() """

# Rutas Recetas
@recipe.get("/recetas/")
def index():
    return recipeController.index(mongodb)

@recipe.get("/receta/{recipe_id}")
def show(recipe_id: int):
    return recipeController.show(mongodb, recipe_id)

@recipe.post("/receta/")
def store(recipe: Recipe):
    return recipeController.store(mongodb, recipe)

@recipe.put("/receta/{recipe_id}")
def update(recipe_id, recipe: Recipe):
    return recipeController.update(mongodb, recipe_id, recipe)

@recipe.delete("/receta/{recipe_id}")
def delete(recipe_id, recipe: Recipe):
    return recipeController.delete(mongodb, recipe_id)