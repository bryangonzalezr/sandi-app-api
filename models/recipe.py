from pydantic import BaseModel, Field
from typing import List, Optional

class Recipe(BaseModel):
    label: str
    diet_labels: List[str]
    health_labels: List[str]
    cautions: List[str]
    ingredient_lines: List[str]
    calories: float
    glycemic_index: Optional[float] = Field(None)
    inflammatory_index: Optional[float] = Field(None)
    meal_type: List[str]
    dish_type: List[str]
    instructions: Optional[List[str]] = Field(None)

    @classmethod
    def from_dict(cls, data: dict) -> 'Recipe':
        return cls(
            label=data['label'],
            diet_labels=data['dietLabels'],
            health_labels=data['healthLabels'],
            cautions=data['cautions'],
            ingredient_lines=data['ingredientLines'],
            calories=data['calories'], 
            glycemic_index=data.get('glycemic_index'),
            inflammatory_index=data.get('inflammatory_index'),
            meal_type=data['mealType'],
            dish_type=data['dishType'],
            instructions=data.get('instructions'),
        )

    