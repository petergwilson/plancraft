# plancraft / regcraft
## Advanced planning and regulatory software, 
Peter Wilson, 2024
Wilson Environmental Limited

## Outline
The development, maintenance, implementation, and evaluation of planning and regulatory documents - both government and private - remains a largely manual process. 
There are substantial overlaps between software engineering in the development, and maintenance of policy documents. However, given the non-machine/human intended users of these documents
the implementation and evaluation cycles of the planning process currently remain substantially outside of the computable realm. This is despite a substantial data universe, both spatial
and non-spatial information being available. 

![image](https://github.com/user-attachments/assets/578c9938-9232-4e29-a104-9a053e870bb1)
Caption: Quality Planning, https://www.qualityplanning.org.nz/sites/default/files/inline-images/planning_process_cycle.png

## The plancraft research

Policies, plans, rules, and regulatory documents are code - of a form. The writers of them engage in mental challenges similar to software engineers. 
However, policies, plans, and rules are not machine interpretable. The vast amount of data that explains, or may explain, the regulatory environments is not available to 







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










