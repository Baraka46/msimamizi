from fastapi import FastAPI
from pydantic import BaseModel
from selenium import webdriver
from typing import List
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

app = FastAPI()

class PlateRequest(BaseModel):
    plates: List[str]

def scrape_single_plate(plate: str):
    chrome_options = Options()
    chrome_options.add_argument("--headless")
    chrome_options.add_argument("--no-sandbox")
    chrome_options.add_argument("--disable-dev-shm-usage")

    driver = webdriver.Chrome(options=chrome_options)
    try:
        driver.get("https://tms.tpf.go.tz")
        wait = WebDriverWait(driver, 15)

        search_input = wait.until(EC.element_to_be_clickable((By.CLASS_NAME, "search-input")))
        driver.execute_script("arguments[0].value = '';", search_input)
        search_input.send_keys(plate)

        search_button = wait.until(EC.element_to_be_clickable((By.CLASS_NAME, "search-button")))
        search_button.click()

        modal = wait.until(EC.presence_of_element_located((By.ID, "modal")))
        time.sleep(2)

        table = modal.find_element(By.CLASS_NAME, "transaction-table")
        rows = table.find_elements(By.TAG_NAME, "tr")
        records = []

        for row in rows[1:]:
            cells = row.find_elements(By.TAG_NAME, "td")
            if len(cells) < 9:
                continue
            records.append({
                "SN": cells[0].text,
                "Reference": cells[1].text,
                "License": cells[2].text,
                "Location": cells[3].text,
                "Offence": cells[4].text,
                "Charge": cells[5].text,
                "Penalty": cells[6].text,
                "Status": cells[7].text,
                "Issued Date": cells[8].text,
            })

        return {"plate_number": plate, "records": records}

    except Exception as e:
        return {"plate_number": plate, "error": "Scraping failed", "details": str(e)}

    finally:
        driver.quit()

@app.post("/scrape")
def scrape_vehicle_info(data: PlateRequest):
    results = []
    for plate in data.plates:
        cleaned_plate = plate.strip()
        result = scrape_single_plate(cleaned_plate)
        results.append(result)
    return {"results": results}
                                                                                                                                                                                                                                                                                                                                                                                 