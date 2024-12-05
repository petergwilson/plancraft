

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException
from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import StaleElementReferenceException
import urllib 
from bs4 import BeautifulSoup
import subprocess 
import psycopg2
import time
import html

mydriver = webdriver.Firefox()
#Constants

#Plan constants
#May later get from somewhere else
plan="wdc.pdp"
level1pointer="none"
level2pointer="none"
id=1; 


def click_buttons(buttons,selector):
  for button in buttons:
        #print("Test")
        texthtml=button.get_attribute('outerHTML')
        #print (texthtml)
        #print(mydriver.find_element(By.XPATH,"/html/body/div/main/div/div[2]/div/div[3]/div/div[1]/div[1]/div").get_attribute("OuterHTML")) 
        #print(html.find('aria-expanded="false"'))
        if 'aria-expanded="false"' in texthtml: 
            #print()
            #click it
            button.click()
            #extract_text(mydriver.find_element(By.XPATH,selector).get_attribute("innerHTML"))
            new_buttons=mydriver.find_elements(By.XPATH,selector)
            #run recursively on the new list of buttons
            click_buttons(new_buttons,selector)        

def extract_text(text):
    try:
        result = subprocess.run(
        ['php', "parser.php "+text],    # program and arguments, unescape the HTML
        stdout=subprocess.PIPE,  # capture stdout
        check=True               # raise exception if program fails
        )
        print(result.stdout)         # result.stdout contains a byte-string    
    except subprocess.CalledProcessError as e:
        print (e.returncode)
        print (e.output) 

baseurl = """https://waimakariri.isoplan.co.nz/draft/"""
mydriver.get(baseurl)
timeout=5 #5 seconds
#Disclaimer Button
try:
 
    element_present = EC.presence_of_element_located((By.ID, 'divLandingPageActions'))
    WebDriverWait(mydriver, timeout).until(element_present)
except TimeoutException:
    print("Timeout")

finally:
    mydriver.find_element(By.XPATH,"/html/body/div[3]/div/div/div[3]/button").click()
#Open Plan

try:

    element_present = EC.presence_of_element_located((By.ID, 'divLandingPageActions'))
    WebDriverWait(mydriver, timeout).until(element_present)
except TimeoutException:
    print("Timeout")

finally:
    mydriver.find_element(By.XPATH,'/html/body/div/main/div/div/div[2]/div[2]/div/button[1]').click()

#Get List of Nav Buttons (and Click on each of them)
try:

    element_present = EC.presence_of_element_located((By.ID, 'sectionsPanel'))
    WebDriverWait(mydriver, timeout).until(element_present)
except TimeoutException:
    print("Timeout")

finally:


    section1="/html/body/div/main/div/div[1]/div/div[4]/div[1]//button"
    section2="/html/body/div/main/div/div[1]/div/div[4]/div[2]//button"
    section3="/html/body/div/main/div/div[1]/div/div[4]/div[3]//button"
    click_buttons(mydriver.find_elements(By.XPATH,section1),section1)
    click_buttons(mydriver.find_elements(By.XPATH,section2),section2)
    click_buttons(mydriver.find_elements(By.XPATH,section3),section3)

    #Need to go through links that have no aria-expanded tag at all and extract HTML content from them
    #And put into database. 
    
    elem=mydriver.find_elements(By.XPATH,"//button")
    pageid=0

    for button in elem:
       
        texthtml=button.get_attribute("outerHTML")
        #print(texthtml) 
     
            
        if ("aria-expanded" not in texthtml) and ('role="link"') in texthtml:
        #if ('role="link"') in texthtml:
            #print(texthtml)
            pageid=pageid+1 
            button.click()
            #Extract rule elements
            try:
                #element_present = EC.presence_of_element_located((By.CLASS_NAME, 'divRuleText'))
                #WebDriverWait(mydriver, timeout).until(element_present)
                #time.sleep(0.5)    
                element_present = EC.presence_of_element_located((By.ID, '__isoplan_rules_container'))
                WebDriverWait(mydriver, timeout).until(element_present)
                
                ruletext=mydriver.find_element(By.ID,"__isoplan_rules_container").get_attribute("outerHTML")
                print(pageid)
                
                filename=button.get_attribute("innerHTML")
                filename2=filename.replace("/","")
                text_file=open(filename2+"_"+str(pageid)+"_.html","w")

                text_file.write(ruletext)

                text_file.close
                


            except NoSuchElementException as e:
                print(e) # and/or other actions to recover

            except TimeoutException as e:
                print(texthtml+e+": Timeout")
                #print(rule_details)
            except StaleElementReferenceException as e:
                print(texthtml+e)


  
            



  

    
