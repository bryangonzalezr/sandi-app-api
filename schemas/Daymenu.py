def daymenuEntity(item) -> dict:
    return{
        "id": str(item["_id"]),
        "recipes" : item.get("recipes"),
        "total_calories" : item.get("totalCalories"),
    }
    
def daymenusEntity(entity) -> list:
    return [daymenuEntity(item) for item in entity]