import sys
import time
import json
from difflib import SequenceMatcher
from selenium import webdriver
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import StaleElementReferenceException


def handleInput():
    arguments = sys.argv
    if (len(arguments) < 1):
        raise Exception("Faltan parámetros")
    del arguments[0]
    ingredients = arguments
    return (arguments, ingredients)

def scrapAcuenta(ingredient, driver):
    market = "acuenta"
    if("_" in ingredient):
        url_ingredient = ingredient.replace("_","%20")
        formatted_ingredient = ingredient.replace("_"," ").lower()
        url = f'https://www.acuenta.cl/search?name={url_ingredient}'
        driver.get(url)

        element = WebDriverWait(driver, 20).until(
            EC.presence_of_element_located((By.CLASS_NAME, 'infinite-scroll-component '))
        )
        try:
            products = element.find_elements(By.CLASS_NAME, 'general__content')
        except StaleElementReferenceException:
            element = WebDriverWait(driver, 20).until(
            EC.presence_of_element_located((By.CLASS_NAME, 'infinite-scroll-component '))
        )
            products = element.find_elements(By.CLASS_NAME, 'general__content')

        max_value = 0
        count = 0
        i = 0
        for product in products:
            products_details = product.find_elements(By.CLASS_NAME, 'CardName__CardNameStyles-sc-147zxke-0 bWeSzf prod__name')
            scrapped_name = products_details.text.lower()
            for details in products_details:
                comparation = SequenceMatcher(None, formatted_ingredient, scrapped_name).ratio()
                if(comparation >= max_value):
                    max_value = comparation
                    i=count
                    count+=1
                else:
                    count+=1
        scrapped_price = getPrice(products[i], market)

    elif ("_" not in ingredient):
        url = f'https://www.acuenta.cl/search?name={ingredient}'
        driver.get(url)

        element = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, 'styles__ProductsStyles-sc-824wwv-0 jsaLih'))
        )

        product_name = element.find_element(By.CLASS_NAME, 'CardName__CardNameStyles-sc-147zxke-0 bWeSzf prod__name')
        for name in product_name:
            scrapped_name = name.text.split()
            if(scrapped_name[0].lower() == ingredient.lower()):
                scrapped_price = getPrice(name, market)
    else:
        raise Exception('El ingrediente ingresado no está formateado')

    return scrapped_price

def scrapJumbo(ingredients, driver):
    market = "jumbo"
    shopping_list={}
    for ingredient in ingredients:
        if("_" in ingredient):
            url_ingredient = ingredient.replace("_","%20")
            formatted_ingredient = ingredient.replace("_"," ").lower()
            url = f'https://www.jumbo.cl/busqueda?ft={url_ingredient}'
            driver.get(url)

            element = WebDriverWait(driver, 10).until(
                EC.presence_of_element_located((By.CLASS_NAME, 'shelf-content'))
            )
            try:
                product_name = element.find_elements(By.CLASS_NAME, 'product-card-name')
            except StaleElementReferenceException:
                element = WebDriverWait(driver, 10).until(
                    EC.presence_of_element_located((By.CLASS_NAME, 'shelf-content'))
                )
                product_name = element.find_elements(By.CLASS_NAME, 'product-card-name')

            max_value = 0
            count = 0
            i = 0
            for name in product_name:
                scrapped_name = name.text.lower()
                comparation = SequenceMatcher(None, formatted_ingredient, scrapped_name).ratio()
                if(comparation >= max_value):
                    max_value = comparation
                    i=count
                    count+=1
                else:
                    count+=1
            scrapped_price = getPrice(product_name[i], market)
            shopping_list[ingredient] = scrapped_price

        elif ("_" not in ingredient):
            url = f'https://www.jumbo.cl/busqueda?ft={ingredient}'
            formatted_ingredient = ingredient.lower()
            driver.get(url)

            element = WebDriverWait(driver, 10).until(
                EC.presence_of_element_located((By.CLASS_NAME, 'shelf-content'))
            )

            try:
                product_name = element.find_elements(By.CLASS_NAME, 'product-card-name')
            except StaleElementReferenceException:
                element = WebDriverWait(driver, 10).until(
                    EC.presence_of_element_located((By.CLASS_NAME, 'shelf-content'))
                )
                product_name = element.find_elements(By.CLASS_NAME, 'product-card-name')
            max_value = 0
            count = 0
            i = 0
            for name in product_name:
                scrapped_name = name.text.lower()
                comparation = SequenceMatcher(None, formatted_ingredient, scrapped_name).ratio()
                if(comparation >= max_value):
                    max_value = comparation
                    i=count
                    count+=1
                else:
                    count+=1

            scrapped_price = getPrice(product_name[i], market)
            shopping_list[ingredient] = scrapped_price

        else:
            raise Exception('El ingrediente ingresado no está formateado')

    return shopping_list

def getPrice(element, market):
    if (market == "jumbo"):
        product_price = element.find_element(By.XPATH, './..').find_elements(By.CLASS_NAME, 'prices-main-price')
        if(len(product_price) == 0):
            scrapped_price = "no hay stock"
        else:
            for price in product_price:
                scrapped_price = price.text
                break
        return scrapped_price
    elif (market == "acuenta"):
        product_price = element.find_elements(By.CLASS_NAME, 'CardBasePrice__CardBasePriceStyles-sc-1dlx87w-0 bhSKFL base__price')
        if(len(product_price) == 0):
            scrapped_price = "no hay stock"
        else:
            scrapped_price = product_price[0].text
        return scrapped_price

def main():
    try:
        values, ingredients = handleInput()
        options = webdriver.ChromeOptions()
        options.add_argument("--headless")
        options.add_argument("--no-sandbox")
        options.add_argument("--disable-dev-shm-usage")
        options.add_argument("--disable-gpu")
        options.add_argument("--disable-extensions")
        driver = webdriver.Chrome(options=options)
        price = scrapJumbo(ingredients, driver)
        #price = scrapAcuenta(ingredient, driver)
        driver.quit()
        if (price == "no hay stock"):
            print("ok," + "no hay stock de este ingrediente")
        else:
            print("ok," + json.dumps(price))

    except Exception as error:
        print("error,"+str(error))


if __name__ == '__main__':
    main()
