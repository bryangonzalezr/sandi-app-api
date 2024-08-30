import math

def handleInput():
     arguments = sys.argv
    if (len(arguments) < 7):
        raise Exception("Faltan parámetros")
    del arguments[0]
    suprailiac_skinfold = arguments.pop()
    supraspinal_skinfold= arguments.pop()
    subescapular_skinfold= arguments.pop()
    tricipital_skinfold= arguments.pop()
    bicipital_skinfold= arguments.pop()
    return (arguments, suprailiac_skinfold, supraspinal_skinfold, subescapular_skinfold, tricipital_skinfold, bicipital_skinfold)

def calculateData():


def main():
    try:
        values, suprailiac_skinfold, supraspinal_skinfold,
        subescapular_skinfold, tricipital_skinfold, bicipital_skinfold = handleInput()
if __name__ == '__main__':
    main()
