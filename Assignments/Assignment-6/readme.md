Event Bubbling in JS :
Definition
When an event happens on an element, it first runs the handlers on it, then on its parent, then all the way up on other ancestors.This process is called “bubbling”, because events “bubble” from the inner element up through parents like a bubble in the water.
How event bubbling occurs
As we can see in (eventbubbling.html) , there are 3 div elements that are nested inside one another ie grandparent, parent and child. An event click is added in all these elements and some message is displayed in the console according to their id's.
When we clicked on the div with the child as its id, we should get the output as ‘child’ on our console. But unexpectedly, we are receiving a different output even we have not clicked on divs with parent and grandparent as their id. The concept of event bubbling comes into the picture. The child div lies inside the parent div as well as in the grandparent div. So, when the child div clicked, we indirectly clicked on both parent div and grandparent div. Thus, propagation is moving from inside to outside in the DOM or we can say events are getting bubble up.
Therefore, this process of propagating from the closest element to the farthest away element in the DOM (Document Object Modal) is called event bubbling.
Event Capturing in JS :
Definition
Event capturing means propagation of event is done from ancestor elements to child element in the DOM
How event capturing occurs
It’s clearly visible in our sample program (eventcapturing.html) that the ancestor divs of the child div were printing first and then the child div itself. So, the process of propagating from the farthest element to the closest element in the DOM is called event capturing. Both terms are just opposite of each other.
The event capturing of event listeners happens first and then the event bubbling happened. This means the propagation of event listeners first goes from outside to inside and then from inside to outside in the DOM. The event capturing occurs followed by event bubbling.
If {capture: true} ,event capturing will occur else event bubbling will occur.
Stopping event bubbling and event capturing
A bubbling event goes from the target element straight up. Normally it goes upwards till , and then to document object, and some events even reach window, calling all handlers on the path.
But any handler may decide that the event has been fully processed and stop the bubbling.
The method for it is event.stopPropagation().
The stopPropagation() method of the Event interface prevents further propagation of the current event in the capturing and bubbling phases. It does not, however, prevent any default behaviors from occurring; for instance, clicks on links are still processed.