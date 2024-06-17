from pydantic import BaseModel
from typing import List, Optional

class Recipe(BaseModel):
    id: str
    label: str
    image: str
    level: int
    summary: str
    calories: float
    totalWeight: float
    ingredients: List[dict]
    totalNutrients: List[dict]
    totalDaily: List[dict]
    dietLabels: str
    healthLabels: str

    