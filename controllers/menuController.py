from fastapi import Response, HTTPException
from models.userData import UserData
from models.Menu import Menu
from models.Daymenu import DayMenu
from models.recipe import Recipe
from schemas.Menu import menuEntity, menusEntity
from controllers.daymenuController import generate_day_menu
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
    return menusEntity(db.menus.find())

def show(db, menu_id: str):
    db = getattr(db, DBM_NAME)
    return menuEntity(db.menus.find_one({"_id": ObjectId(menu_id)}))

def store(db, menu: Menu):
    db = getattr(db, DBM_NAME)
    new_menu = dict(menu)
    daymenus_dict = []
    for daymenu in new_menu["menus"]:
        daymenus_dict.append(dict(daymenu))
    
    new_menu["menus"] = daymenus_dict

    for daymenu in new_menu["menus"]:
        recipes_dict = []
        for recipe in daymenu["recipes"]:
            recipes_dict.append(dict(recipe))
        
        daymenu["recipes"] = recipes_dict
    
    

    id = db.menus.insert_one(new_menu).inserted_id
    db_menu = menuEntity(db.menus.find_one({"_id": ObjectId(id)}))
    return db_menu



def update(db, menu_id: str, menu: Menu):
    db = getattr(db, DBM_NAME)
    db_menu = menuEntity(db.menus.find_one_and_update({"_id": ObjectId(menu_id)}, {"$set": dict(menu)}, return_document=True))

    return db_menu

def delete(db, menu_id: str):
    db = getattr(db, DBM_NAME)
    menuEntity(db.menus.find_one_and_delete({"_id": ObjectId(menu_id)}))
    return Response(status_code=HTTP_204_NO_CONTENT)

async def generate_menu(timespan: int, userData: UserData):
    try:
        menu = Menu(menus=[], timespan=timespan)
        
        for _ in range(timespan):
            day_menu = await generate_day_menu(userData)
            menu.menus.append(day_menu)
        
        return menu
    
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))
   
        
        