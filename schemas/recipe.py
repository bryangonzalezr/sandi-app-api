def recipeEntity(item) -> dict:
    try:
        recipe = {
        "id": str(item["_id"]),
        "label": item.get("label"),
        "calories": item.get("calories"),
        "glycemic_index": item.get("glycemic_index"),
        "inflammatory_index": item.get("inflammatory_index"),
        "diet_labels": item.get("diet_labels"),
        "health_labels": item.get("health_labels"),
        "cautions": item.get("cautions"),
        "ingredient_lines": item.get("ingredient_lines"),
        "meal_type": item.get("meal_type"),
        "dish_type": item.get("dish_type"),
        "instructions": item.get("instructions"),
    }
        return recipe
    except Exception as e:
        return {"message": "No se encontró la receta"}

def recipesEntity(entity) -> list:
    return [recipeEntity(item) for item in entity]