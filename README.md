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

## The plancraft philosophy

* Policies, plans, rules, and regulatory documents are code. They are maps, codes, instructions, algorithms for particular tasks. Logical flow is a component of them, or, where there are logical errors, documents may fail the relevant legal tests.
* The writers of them engage in mental challenges similar to software engineers in their development, they are subject to similar scrutiny and peer-review as software. 
* However, currently there is a key difference - policies, plans, and rules are not machine interpretable. The vast amount of data that explains, or may explain, a particular regulatory environments is not machine accessible or available.
* Manual processes are still the basis for policy and regulatory development and implementation. 
* There is no automation or semi-automation in evaluation and review either. Evaluation and review is generally not integrated with development (compare with a unit test for instance). 
* Given the legal context in which regulatory documents exist, AI is not currently an answer, as repeated, reliable, and traceable working are required.
* Practioners must have confidence in any results
* To have confidence in results, requires a workflow and design philosophy where results are transparent and reproducible. 
* Practioner confidence is also greatly enhanced by being able to contribute to results and workflows, and to receive peer recognition for contributions.
* **This last point is perhaps the most important - any system is limited by the support of its users - particularly when the context is legal. Thus, closed-source approaches will always have their limits and open source approaches may be better 
suited**


## The plancraft research challenge

### Plans as code
* A regulatory document is more than text, the logical flow, ordering, branching, switching, and exception handling is integrated within its structure.
* Plans have a fundamental relationship with space and place, so text and any logic is always bounded in location. Geospatial integration is implicit.
* Version control is implicit and essential, but not handled well in current approaches.
#### Fundamental R&D challenge 1
Turning regulatory logic into computer logic, whilst ensuring transparency and repeatability in doing so. Approaches to achievement include:
* Parser that is designed for regulatory language
* Control, flow, and logic detection parser
* Graphical flow structures for human confirmation

### Computablity and identification of geospatial context
* Plans contain contextual links in text to space and place, with complex and overlapping bounds of space and time at various scales.
* These links need to be identified. 
* Substantial electronic geospatial information exists to link text to space and place, however, there is no current approach for any given document corpus within defined spatial parameters whilst still ensuring computability and algorithmic efficiency.

#### Fundamental R&D challenge 2
Linking spatial and aspatial information. Approaches to achievement include:
* Geoscraping and discovery, to automate the understanding, of what data may or may not be available in any given context
* Linking vectors for terms within documents to spatial scope.
* The same approach of a linking vector may extend to legal and other contexts too

### Version control
* Regulatory documents struggle with version control approaches that have been resolved by software engineers many years ago
* It is not a particular R&D task, however, the human interface component needs careful thought - it must work for people where they are now.
* This means Microsoft Office integration, combined with a git, or git-like approach for version control. 












