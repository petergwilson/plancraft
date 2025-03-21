# plancraft / regcraft
## Advanced planning and regulatory software

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

* Policies, plans, rules, and regulatory documents are code. They are maps, codes, instructions, algorithms for particular tasks. Logical flow is a component of them, or, where there are logical errors, documents may fail the relevant legal tests.
* The writers of them engage in mental challenges similar to software engineers in their development, they are subject to similar scrutiny and peer-review as software. 
* However, currently there is a key difference - policies, plans, and rules are not machine interpretable. The vast amount of data that explains, or may explain, a particular regulatory environments is not machine accessible or available.
* Manual processes are still the basis for policy and regulatory development and implementation
* There is no automation or semi-automation in evaluation and review either. Evaluation and review is generally poorly done. 
* Given the legal context in which regulatory documents exist, AI is not currently an answer, as repeated, reliable, and traceable working are required.
* Practioners must have confidence and be able to contribute to responses. 








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










