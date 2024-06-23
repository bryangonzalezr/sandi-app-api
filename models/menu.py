from models.daymenu import DayMenu
from pydantic import BaseModel, Field
from typing import List, Optional



class Menu(BaseModel):
    timespan: int
    menus: List[DayMenu]

