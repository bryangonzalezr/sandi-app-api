from fastapi import APIRouter, Depends
from sqlalchemy.orm import Session

from models.Daymenu import DayMenu
from models.Recipe import Recipe
from models.UserData import UserData
from controllers import daymenuController
from database.database import SessionLocal, engine
from database.mongo import conn as mongodb


daymenu = APIRouter()


@daymenu.post("/daymenu/generate")
async def generate_day_menu(userData: UserData):
    return await daymenuController.generate_day_menu(userData)

@daymenu.get("/daymenu/")
def index():
    return daymenuController.index(mongodb)

@daymenu.get("/daymenu/{daymenu_id}")
def show(daymenu_id: str):
    return daymenuController.show(mongodb, daymenu_id)

@daymenu.post("/daymenu/")
def store(daymenu: DayMenu):
    return daymenuController.store(mongodb, daymenu)

@daymenu.put("/daymenu/{daymenu_id}")
def update(daymenu_id, daymenu: DayMenu):
    return daymenuController.update(mongodb, daymenu_id, daymenu)

@daymenu.delete("/daymenu/{daymenu_id}")
def delete(daymenu_id):
    return daymenuController.delete(mongodb, daymenu_id)

