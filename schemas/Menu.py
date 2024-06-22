def menuEntity(item) -> dict:
    return{
        "timespan" : item.get("timespan"),
        "menus" : item.get("menus"),
        
    }
    
def menusEntity(entity) -> list:
    return [menuEntity(item) for item in entity]