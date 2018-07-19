import time
import datetime
import json
import urllib2
from pymongo import MongoClient
client = MongoClient('mongodb://qqbot:qqbot123@ds247410.mlab.com:47410/qqbot')
db = client.get_database("qqbot")
col = db.pyfloodnoti
def pushRECORD(record):
    col.insert_one(record)
def updateRecord(updates):
    col.update_one({'id': "1"},{'$set': updates}, upsert=False)
def getRECORD(id):
    records = col.find_one({"id":id})
    return records
while(True):
    print("CheckData At "+str(datetime.datetime.now()))
    data = json.load(urllib2.urlopen("http://www.crflood.com/crflood/boat/pyfloodbot/notipyflood.php"))
    data_old = getRECORD("1")['data']
    try:
        for i in range(len(data_old)):
            if(data[i]['status']!=data_old[i]['status']):
                masg = "station : "+str(data[i]['station_code'])+" change mode from "+str(data_old[i]['status'])+" to "+str(data[i]['status'])
                print(masg)
                date = str(data[i]['time_water']).split(" ")[0];
                timestr = str(data[i]['time_water']).split(" ")[1];
                urllib2.urlopen("http://128.199.91.90/crflood/boat/pyfloodbot/botpush.php?stationid="+str(data[i]['station_code'])+"&modeold="+str(data_old[i]['status'])+"&modenew="+str(data[i]['status'])+"&water="+str(data[i]['water'])+"&date="+date+"&time="+timestr)
    except:
        print("new data")
    if(data !=""):
        dicdata = {"id":"1","date":str(datetime.datetime.now()),"data":data}
        updateRecord(dicdata)
    time.sleep(300)

