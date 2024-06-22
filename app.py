from fastapi import FastAPI
from routes.recipe import recipe
from routes.daymenu import daymenu
from routes.menu import menu

app = FastAPI()
app.include_router(recipe)
app.include_router(daymenu)
app.include_router(menu)
