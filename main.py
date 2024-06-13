from fastapi import FastAPI, Depends
from sqlalchemy.orm import Session

from models import models, schemas
from controllers import recipeController
from database.database import SessionLocal, engine

models.Base.metadata.create_all(bind=engine)

app = FastAPI()

# Dependency
def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()

# Rutas Recetas
@app.get("/recetas/")
def index(db: Session = Depends(get_db)):
    return recipeController.index(db)

@app.get("/receta/")
def show(recipe_id: int, db: Session = Depends(get_db)):
    return recipeController.show(db, recipe_id)

@app.post("/receta/")
def create(recipe: schemas.Recipe, db: Session = Depends(get_db)):
    return recipeController.create(db, recipe)

@app.put("/receta/")
def update(recipe_id: int, recipe: schemas.Recipe, db: Session = Depends(get_db)):
    return recipeController.update(db, recipe_id, recipe)

@app.delete("/receta/")
def delete(recipe_id: int, db: Session = Depends(get_db)):
    return recipeController.delete(db, recipe_id)