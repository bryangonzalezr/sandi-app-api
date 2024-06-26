def recipeEntity(item) -> dict:
    return {
        "id": str(item["_id"]),
        "label": item.get("label"),
        "calories": item.get("calories"),
        "glycemic_index": item.get("glycemicIndex"),
        "inflammatory_index": item.get("inflammatoryIndex"),
        "diet_labels": item.get("dietLabels"),
        "health_labels": item.get("healthLabels"),
        "cautions": item.get("cautions"),
        "ingredient_lines": item.get("ingredientLines"),
        "meal_type": item.get("mealType"),
        "dish_type": item.get("dishType"),
        "instructions": item.get("instructions"),
    }

def recipesEntity(entity) -> list:
    return [recipeEntity(item) for item in entity]