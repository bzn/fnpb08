/*
 * This array is used to remember mark status of rows in browse mode
 */
var marked_row = new Array;

/*
 * Sets / Unsets the pointer and marker in browse mode
 *
 * @param   object    the table row
 * @param   integer   the row number
 * @param   string    the action calling this script (over, out or click)
 * @param   string    the default class name
 * @param   string    the class name to use for mouseover
 * @param   string    the class name to use for marking a row
 *
 * @return  boolean  whether pointer is set or not
 */
function setPointer(theRow, theRowNum, theAction, theDefaultClassName, thePointerClassName, theMarkClassName)
{
    // 1. Pointer and mark feature are disabled or the browser can't get the
    //    row -> exits
    if ((thePointerClassName == '' && theMarkClassName == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }

    // 3. Gets the current class name...
    var domDetect        = null;
    var currentClassName = "";
    var newClassName     = "";
    // 3.1 ... with DOM compatible browsers except Opera that does not return
    //         valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theRow.getAttribute) != 'undefined') {
        currentClassName = theRow.getAttribute('className');
        domDetect        = true;
    }
    // 3.2 ... with other browsers
    else {
        currentClassName = theRow.className;
        domDetect        = false;
    } // end 3
    
    
    // 4. Defines the new class name
    // 4.1 Current class name is the default one
    if (currentClassName == ''
        || currentClassName.toLowerCase() == theDefaultClassName.toLowerCase()) {
        if (theAction == 'over' && thePointerClassName != '') {
            newClassName = thePointerClassName;
        }
        else if (theAction == 'click' && theMarkClassName != '') {
            newClassName = theMarkClassName;
            marked_row[theRowNum] = true;
            // Garvin: deactivated onclick marking of the checkbox because it's also executed
            // when an action (like edit/delete) on a single item is performed. Then the checkbox
            // would get deactived, even though we need it activated. Maybe there is a way
            // to detect if the row was clicked, and not an item therein...
            // document.getElementById('id_rows_to_delete' + theRowNum).checked = true;
        }
    }
    // 4.1.2 Current class name is the pointer one
    else if (currentClassName.toLowerCase() == thePointerClassName.toLowerCase()
             && (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])) {
        if (theAction == 'out') {
            newClassName = theDefaultClassName;
        }
        else if (theAction == 'click' && theMarkClassName != '') {
            newClassName          = theMarkClassName;
            marked_row[theRowNum] = true;
        }
    }
    // 4.1.3 Current class name is the marker one
    else if (currentClassName.toLowerCase() == theMarkClassName.toLowerCase()) {
        if (theAction == 'click') {
            newClassName          = (thePointerClassName != '')
                                  ? thePointerClassName
                                  : theDefaultClassName;
            marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
                                  ? true
                                  : null;
            // document.getElementById('id_rows_to_delete' + theRowNum).checked = false;
        }
    } // end 4

    // 5. Sets the new class name...
    if (newClassName) {
        var c = null;
        // 5.1 ... with DOM compatible browsers except Opera
        if (domDetect) {
            theRow.setAttribute('className', newClassName, 0);
        }
        // 5.2 ... with other browsers
        else {
            theRow.className = newClassName;
        }
    } // end 5

    return true;
} // end of the 'setPointer()' function