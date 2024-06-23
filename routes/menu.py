from fastapi import APIRouter, Depends
from sqlalchemy.orm import Session

from models.Menu import Menu
from models.Daymenu import DayMenu
from models.Recipe import Recipe
from models.UserData import UserData
from controllers import menuController
from database.database import SessionLocal, engine
from database.mongo import conn as mongodb


menu = APIRouter()


@menu.post("/menu/generate")
async def generate_day_menu(timespan: int, userData: UserData):
    return await menuController.generate_menu(timespan,userData)

@menu.get("/menu")
def index(skip: int = 0, limit: int = 100):
    return menuController.index(mongodb, skip, limit)

@menu.get("/menu/{menu_id}")
def show(menu_id: str):
    return menuController.show(mongodb, menu_id)

@menu.post("/menu")
def store(menu: Menu):
    return menuController.store(mongodb, menu)

@menu.put("/menu/{menu_id}")
def update(menu_id: str, menu: Menu):
    return menuController.update(mongodb, menu_id, menu)

@menu.delete("/menu/{menu_id}")
def delete(menu_id: str):
    return menuController.delete(mongodb, menu_id)


