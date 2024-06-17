from fastapi import FastAPI
from routes.recipe import recipe

app = FastAPI()
app.include_router(recipe)