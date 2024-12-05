# plancraft
Advanced planning and regulatory software

Main components:
Scraper.py - scrape Isovist websites for content,save HTML files chapter by chapter
parser.php - get content from HTML files, save to database

To do: Work selenium code to get Variations, other versions etc
Reverse engineer classes to get information on the document - eg cross references
Can use <data-rule-id> tags for using same id tags as Isovist

Check rest of Isovist URL for how it handles variations etc....

planbase - wrapper logic for postgresql. 
Every item is put into postgresql - need to work out schema. Something for plaintext, something for HTML, etc, something for links, something for machine interpretation, something for vectors, something for GIS links, something that stores the plan logic. 
NEED TO WORK OUT HOW TO STORE IT. Most likely as HTML, could also do direct word integration with another way (but hard). 

Any direct word integration needs a way of storing the separation in word - could be by way of styles

word integration: a toolbar, stylesheets, etc that enable word integration. 

Some version of git, that runs on the text. NEED TO WORK OUT GIT in greater detail. It would be sub-versions, you'd then merge with the master... 

Plan logic - some excel like version that enables moving rules around, renumbering etc. Could be excel, it's best suited. Could also be the web. TEND TOWARDS EXCEL. Especially given excel connectors etc
Which means - VBA!!!

Helper - the thing that works through an application

SpatialIntelligence - LINZ tool... 










