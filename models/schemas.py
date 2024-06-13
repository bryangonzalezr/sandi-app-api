from pydantic import BaseModel

class Recipe(BaseModel):
    name: str
    serving_size: int