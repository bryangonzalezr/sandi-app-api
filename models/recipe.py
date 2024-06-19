from pydantic import BaseModel, Field
from typing import List, Optional

class Recipe(BaseModel):
    label: str
    image: str
    images: dict   
    diet_labels: List[str]
    health_labels: List[str]
    cautions: List[str]
    ingredient_lines: List[str]
    ingredients: List[dict]
    calories: float
    glycemic_index: Optional[float] = Field(None)
    inflammatory_index: Optional[float] = Field(None)
    total_weight: float
    cuisine_type: List[str]
    meal_type: List[str]
    dish_type: List[str]
    instructions: Optional[List[str]] = Field(None)
    tags: List[str]
    total_nutrients: dict
    total_daily: dict
    digest: List[dict]