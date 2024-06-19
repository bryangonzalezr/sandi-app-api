from pydantic import BaseModel, Field
from typing import List, Optional

class UserData(BaseModel):
    query: str
    range_ingredients: Optional[str] = Field(None)
    diet: Optional[List[str]] = Field(None)
    health: Optional[List[str]] = Field(None)
    cuisineType: Optional[List[str]] = Field(None)
    mealType: Optional[List[str]] = Field(None)
    dishType: Optional[List[str]] = Field(None)
    calories: Optional[str] = Field(None)
    time: Optional[str] = Field(None)
    glycemicIndex: Optional[str] = Field(None)
    inflammatoryIndex: Optional[str] = Field(None)
    excluded: Optional[List[str]] = Field(None)
    nutrients: Optional[List[dict]] = Field(None)
