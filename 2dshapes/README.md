#### functional specification

Program is a console application that verifies if wall of some configuration can be constructed from
some set of bricks.
While building the wall bricks can be put horizontally as well as vertically.
Brick’s width and height can be from 1 to 8. The configuration of wall is not limited: it can break into
several parts, can seem unstable, can have holes, etc.

The description of wall and bricks is presented in simple text format and can be read from file or from
standard input. The result of verification is printed to standard output, either "yes" (wall can be
constructed) or "no" (wall can not be constructed). Each brick has the rectangular form and discrete
height and width from 1 to 8.  
The format for input data is as follows:  
1. width and height of wall's shape matrix - two positive integers W and H separated by space on their
own line.  
2. wall's shape matrix - H strings each of length W, formed just of '1' and '0' symbols with every string
on its own line.  
3. the count of bricks' sorts - the positive integer C.  
4. list of bricks - C lines each containing three positive integers separated by space - width of brick,
height of brick and count of such bricks in the se

Example of source data
```
6 3
101101
111111
111111
3
1 1 4
2 1 6
1 3 1
```
Example of program output:
```
yes
```


#### design specification
dev environment is php 7.2

used solving algorithm is recursive search of combination of input 2d shapes witch can be combined into wall.  
firstly, data is read from input and turned into two main objects - Wall and BrickStorage  
Each iteration includes steps:
- looking for a start point of wall where can be placed a brick. Currently program considers the point as most top-left filled by 1 position of wall matrix.
- looking for the brick type, which can be placed in this point. For non-square bricks used both orientations - vertical and horizontal.
- when possible brick type is found, placing it on the wall, creating new wall and brick storage without selected brick.
- all iterations is repeated for new wall and storage. 

As soon as some combination leads to wall which does not contain bricks anymore, positive result is returned

#### test instructions
Root directory of application is considered containing run.php file.  
Example test input files is placed in "input" directory.
When running from root directory, file to input file must be relative to current working dir  
For example 
```
# call using file path as argument
php run.php input/test1.txt
# call using standard input
php run.php < input/test1.txt
# or
cat input/test1.txt | php run.php 
``` 
If both types are used in same time, input data from standard input will be ignored. So, if call is
```
php run.php input/test2.txt < input/test1.txt
```  
will be used data from file input/test2.txt
