from models.Recipe import Recipe
from pydantic import BaseModel, Field
from typing import List, Optional



class DayMenu(BaseModel):
    recipes: List[Recipe]
    total_calories: float


