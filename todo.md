### Project fundamentals:

## pc_parser

* To detect plan/regulatory logic in text and build control structures etc. 

## pc_scope framework
* Vector approach for linking text to scope. Linking between different internal components of a regulatory document at different scale and contexts
* (Not a similarity search)

## pc_geoscope framework
* Similar to the scope framework, but linking terms to geospatial contexts at varying scales.
* Will need a geodiscovery binary - to search and extrapolate available geospatial information for contexts and terms

## Best way of thinking of these is similar to small language models but linking to other concepts other than language 

## pc_compliance
* **Killer app** for enabling easy monitoring, evaluation, and compliance based on varying digital twin sources
  
## plancraft add-in for MS Office
* Enabling direct communication between Office and plancraft server
* Needs careful thought to data formats - most likely HTML
* Needs careful thought as to version management and control.
* Most likely git is used alongside the database. Or database approach takes a similar approach to git - given the amount of info things can build up.
* How to handle styles etc.
* **Killer app**

## plancraft web-app

*Viewer and editor
* **Will probably need a Jupyter lab or similar interface to enable the expert system for building an iPlan**

## Things to think about
* Will need SAML authentication and role based access control (RBAC).
* Other things, security incident response policy
* IT Disaster recovery plan
* ISO 27001 certification.
* How it is sold - no code interface. Minimal IT set up, integration. "Narrow and deep"
  


* Take existing known servers




### December 2024:

Old main components early 2024:
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
