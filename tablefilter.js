/*
        TableFilter v2.1 by frequency-decoder.com

        Released under a creative commons Attribution-ShareAlike 2.5 license (http://creativecommons.org/licenses/by-sa/2.5/)

        Please credit frequency decoder in any derivative work - thanks

        You are free:

        * to copy, distribute, display, and perform the work
        * to make derivative works
        * to make commercial use of the work

        Under the following conditions:

                by Attribution.
                --------------
                You must attribute the work in the manner specified by the author or licensor.

                sa
                --
                Share Alike. If you alter, transform, or build upon this work, you may distribute the resulting work only under a license identical to this one.

        * For any reuse or distribution, you must make clear to others the license terms of this work.
        * Any of these conditions can be waived if you get permission from the copyright holder.
*/
var fdTableFilter = (function() {

        var tableCache  = {},
            uniqueHash  = 0,
            imageLoc    = "",
            maxRows     = 200,  // tables smaller than 200 rows can be filtered onkeypress
            keyTimer    = 1000, // the timeout to use when calling the keypress filter function
            scriptFiles = document.getElementsByTagName('script'),
            imgSrc      = scriptFiles[scriptFiles.length - 1].src.substr(0, scriptFiles[scriptFiles.length - 1].src.lastIndexOf("/")) + "blank.gif",
            colRangeStart,
            colRangeFinish,
            currentTableId,
            thNode,            
            timer,
            a,
            delayedTimer,
            embedded;         
        
        var init = function init(tableId) {
                // Can the browser dig it?
                if (!document.getElementsByTagName || !document.createElement || !document.getElementById) return;
                
                var colspan             = (!/*@cc_on!@*/0) ? "colspan" : "colSpan",
                    rowspan             = (!/*@cc_on!@*/0) ? "rowspan" : "rowSpan",
                    tables              = tableId && document.getElementById(tableId) && document.getElementById(tableId).nodeName == "TABLE" ? [document.getElementById(tableId)] : document.getElementsByTagName("table"),
                    a                   = document.createElement("a"),
                    img                 = document.createElement("img"),
                    scaffoldRequired    = false,                     
                    maxLength, dataType, useList, colData, txt, tr, innerText, popup, comparison, comparisonType, rowData, rowArr, rowList, colObj, elem, rowLength, aClone, imgClone, rowStock, workArr, filterList, filterType, filterPrep, celCount, ths, filterable; 
                    
                a.href          = "#";
                a.title         = "Show column filter";
                a.className     = "fdFilterTrigger";
                
                img.alt         = "";                 
                img.src         = imgSrc;                   
                
                for(var k = 0, tbl; tbl = tables[k]; k++) {

                        // Remove any old dataObj for this table (tables created from an ajax callback require this)
                        if(tbl.id) { 
                                clearFilter(tbl.id); 
                                removeTableCache(tbl); 
                        };
                        
                        ths = tbl.getElementsByTagName('th');
                        filterable = false;
                        
                        // Check we have a required className
                        for(var i = 0, th; th = ths[i]; i++) {
                                if(th.className.search(/datatype-([a-zA-Z]{1}[0-9a-zA-Z\_]+)/) == -1) { continue; };
                                filterable = true;
                                break;
                        };

                        if(!filterable) continue;

                        if(!tbl.id) { tbl.id = "fd-table-filter-" + uniqueHash++; };
                        
                        popup           = tbl.className.search(/popup-filter/) != -1;                        
                        rowArr          = [];
                        rowList         = tbl.getElementsByTagName('tr');

                        for(var i = 0;i < rowList.length;i++){
                                rowList[i].className = rowList[i].className.replace(/(^|\b)invisibleRow($|\b)/, "");
                                
                                colObj = [];
                                elem = rowList[i].firstChild;
                                do {
                                        if(elem.tagName && elem.tagName.toLowerCase().search(/td|th/) != -1) { colObj[colObj.length] = elem; };
                                        elem = elem.nextSibling;
                                } while(elem);
                                rowArr.push(colObj);
                        };
                        
                        if(!rowArr.length) { continue; };
                        
                        rowLength = rowArr[0].length;
                        
                        for(var c = 0;c < rowArr[0].length;c++){
                                if(rowArr[0][c].getAttribute(colspan) > 1){
                                        rowLength = rowLength + (rowArr[0][c].getAttribute(colspan) - 1);
                                };
                        };

                        workArr = new Array(rowArr.length);
                        for(var c = rowArr.length;c--;){
                                workArr[c]  = new Array(rowLength);
                        };

                        filterList = {};
                        filterType = {};
                        filterPrep = {};

                        for(var c = 0;c < workArr.length;c++) {
                                celCount = 0;
                                for(var i = 0;i < rowLength;i++) {
                                        if(!workArr[c][i]) {
                                                cel     = rowArr[c][celCount];
                                                colSpan = (cel.getAttribute(colspan) && cel.getAttribute(colspan) > 1) ? cel.getAttribute(colspan) : 1;
                                                rowSpan = (cel.getAttribute(rowspan) && cel.getAttribute(rowspan) > 1) ? cel.getAttribute(rowspan) : 1;
                                                if(cel.tagName.toUpperCase() == "TH" && cel.className.search(/datatype-([a-zA-Z]{1}[0-9a-zA-Z\_]+)/) != -1) {

                                                        dataType        = cel.className.match(/datatype-([a-zA-Z]{1}[0-9a-zA-Z\_]+)/)[1];
                                                        useList         = cel.className.search(/create-list/) != -1;

                                                        if(dataType.search(/^(datedmy|date|numeric|text)$/) == -1 && !(dataType in window && typeof(window[dataType]) == "function")) {
                                                                continue;
                                                        };

                                                        switch(dataType) {
                                                                case "datedmy":
                                                                case "date":
                                                                case "numeric":
                                                                        comparison = "numeric";
                                                                        break;
                                                                case "text":
                                                                        comparison = "text";
                                                                        break;
                                                                default:
                                                                        comparison = cel.className.search(/comparison-numeric/) != -1 ? "numeric" : "text";
                                                        };
                                                        
                                                        for(f = i; f < (i + Number(colSpan)); f++) {
                                                                filterType[f]   = { "dataType":dataType, "useList":useList, "comparison":comparison };
                                                                filterList[f]   = "";
                                                                filterPrep[f]   = "";
                                                                
                                                                if(f == i && !popup) {
                                                                        filterType[f].colspan = colSpan;
                                                                        filterType[f].colStart = i;
                                                                        filterType[f].colEnd   = i + Number(colSpan);
                                                                };
                                                        };
                                                        
                                                        cel.className = cel.className.replace(/fdFilterProcessed-([\d]*)-([\d]*)/, "");
                                                        addClassName(cel, " fdFilterProcessed-" + i + "-" + (i + Number(colSpan)));
                                                        
                                                        if(popup) {
                                                                aClone          = a.cloneNode(true);
                                                                imgClone        = img.cloneNode(true);
                                                        
                                                                aClone.appendChild(imgClone);
                                                                aClone.onclick = aClone.onkeypress = showFilter;
                                                                cel.insertBefore(aClone, cel.firstChild);
                                                        };
                                                };
                                                
                                                for(var t = 0;((t < colSpan)&&((i+t) < rowLength));t++){
                                                        for(var n = 0;((n < rowSpan)&&((c+n) < workArr.length));n++){
                                                                workArr[(c+n)][(i+t)] = cel;
                                                        };
                                                };
                                                if(++celCount == rowArr[c].length) { break; };
                                        };
                                };

                                workArr[c].push(workArr[c][0].parentNode);
                        };
                        
                        rowData         = [];
                        maxLength       = new Array(workArr[0].length);                         
                        
                        for(var r = 0;r < workArr.length;r++) {
                                tr = workArr[r][workArr[r].length - 1];

                                if(tr.getElementsByTagName("th").length || tr.parentNode.tagName == "TFOOT") {  continue; };
                                
                                colData = [];
                                
                                for(var c = 0; c < workArr[r].length - 1; c++) {
                                        if(c in filterList) {
                                                innerText = getInnerText(workArr[r][c]);
                                                if(!maxLength[c] || innerText.replace(/^\s\s*/, '').replace(/\s\s*$/, '').length > maxLength[c]) {
                                                        maxLength[c] = innerText.replace(/^\s\s*/, '').replace(/\s\s*$/, '').length;
                                                };
                                                if(filterType[c].dataType.search(/^(date|datedmy)$/) != -1) {
                                                        colData.push([dateFormat(innerText.replace(/^\s\s*/, '').replace(/\s\s*$/, ''), filterType[c].dataType.indexOf("dmy") != -1), innerText]);
                                                } else if(filterType[c].dataType == "numeric") {
                                                        colData.push([parseFloat(innerText.replace(/[^0-9\.\-]/g,'')), innerText]);
                                                } else if(filterType[c].dataType in window && window[filterType[c].dataType] instanceof Function){
                                                        colData.push([window[filterType[c].dataType](workArr[r][c], innerText), innerText]);
                                                } else {
                                                        colData.push([innerText.replace(/^\s\s*/, '').replace(/\s\s*$/, ''), innerText]);
                                                };

                                        } else {
                                                colData.push([" ", " "]);
                                        };
                                };

                                rowData.push({ "columnData":colData, "trNode":tr });
                        };
                                
                        tableCache[tbl.id] = {
                                "callbacks":{
                                        "create":parseCallback(/^callback-create-/, /callback-create-([\S-]+)/gi, tbl.className),
                                        "filter":parseCallback(/^callback-filter-/, /callback-filter-([\S-]+)/gi, tbl.className)
                                },
                                "filterList":filterList,
                                "filterType":filterType,
                                "filterPrep":{},
                                "filterMath":{},
                                "maxLength":maxLength,
                                "numberOfRows":workArr.length,
                                "rowData":rowData,
                                "rowStyle":tbl.className.search(/rowstyle-([\S]+)/) != -1 ? tbl.className.match(/rowstyle-([\S]+)/)[1] : false
                        };
                        
                        if(popup) {
                                scaffoldRequired = true;                                 
                        } else {
                                var tr          = document.createElement("tr"),
                                    th          = document.createElement("th"),
                                    form        = document.createElement("form"),
                                    p           = document.createElement("p"),
                                    inp         = document.createElement("input"),
                                    sel         = document.createElement("select"),
                                    nbsp        = String.fromCharCode(160),
                                    cellCnt     = 0,
                                    thC, pC;
                                    
                                tr.className    = "fdFilterTableRow";
                                form.method     ="post";
                                form.action     = ""; 
                                inp.type        = "text";
                                
                                for(var i = 0;((i < rowLength) && (cellCnt < rowLength));i++) {
                                        thC = th.cloneNode(true);

                                        if(i in filterType && "colspan" in filterType[i]) {
                                                pC  = p.cloneNode(false);
                                                if(filterType[i].colspan > 1) { thC.colspan = filterType[i].colspan; }
                                                formC = form.cloneNode(true);
                                                formC.name = formC.id = "form-" + tbl.id + "-" + i + "-" + (i + filterType[i].colspan);
                                                if(!filterType[i].useList) {
                                                        inpC = inp.cloneNode(true);
                                                        inpC.id = inpC.name = tbl.id + "-" + i + "-" + (i + filterType[i].colspan);
                                                        formC.onsubmit = embeddedFilter;
                                                        if(workArr.length < maxRows && tbl.className.search('no-keypress-filter') == -1) inpC.onkeyup = delayedFilter;
                                                        inpC.setAttribute("maxlength", Number(maxLength[i]) + 2);
                                                        pC.className = "fdInpContainer";
                                                } else {
                                                        inpC = sel.cloneNode(true);
                                                        inpC.name = inpC.id = tbl.id + "-" + i + "-" + (i + filterType[i].colspan);
                                                        buildSelectList(inpC, tbl.id, cellCnt, cellCnt + filterType[i].colspan);
                                                        inpC.onchange = embeddedFilter;                                                          
                                                        filterType[i].selectListRef = inpC;
                                                };
                                                inpC.className = "fdFilter-" + i;
                                                pC.appendChild(inpC);
                                                formC.appendChild(pC);
                                                thC.appendChild(formC);
                                                
                                                cellCnt += filterType[i].colspan;
                                        } else {
                                                thC.appendChild(document.createTextNode(nbsp));
                                                cellCnt++;
                                        };

                                        tr.appendChild(thC);
                                };

                                if(tbl.getElementsByTagName('thead').length > 0) {
                                        tbl.getElementsByTagName("thead")[0].appendChild(tr);
                                } else {
                                        var trs = tbl.getElementsByTagName('tr'),
                                            inserted = false;
                                            
                                        for(var i = 0, thCheck; thCheck = trs[i]; i++) {
                                                if(!thCheck.getElementsByTagName('th').length) {
                                                        thCheck.parentNode.insertBefore(tr, thCheck);
                                                        inserted = true;
                                                        break;
                                                };
                                        };
                                        
                                        if(!inserted) {
                                                tbl.insertBefore(tr, trs[0]);
                                        };
                                };
                        };                          
                       
                        callback(tbl.id, "create", {"tableId":tbl.id});
                };

                if(scaffoldRequired) { buildScaffold(); };                
                colHead = null;                                            
        };
       
        var parseCallback = function(head, regExp, cname) {
                var cbs    = [],
                    matchs = cname.match(regExp),
                    parts, obj, func;
                
                if(!matchs) { return []; };
                  
                for(var i = 0, mtch; mtch = matchs[i]; i++) {                         
                        mtch = mtch.replace(head, "").replace(/-/g, ".");
                         
                        try {
                                if(mtch.indexOf(".") != -1) {
                                        parts = mtch.split('.');
                                        obj   = window;
                                        for (var x = 0, part; part = obj[parts[x]]; x++) {
                                                if(part instanceof Function) {
                                                        (function() {
                                                                var method = part;
                                                                func = function (data) { method.apply(obj, [data]) };
                                                        })();
                                                } else {
                                                        obj = part;
                                                };
                                        };
                                } else {
                                        func = window[mtch];
                                };
                            
                                if(!(func instanceof Function)) continue;
                                cbs[cbs.length] = func;                              
                        } catch(err) {};
                };
                
                return cbs;                      
        };
        
        var callback = function(tblId, cback, opts) {                
                if(!(tblId in tableCache) || !(cback in tableCache[tblId]["callbacks"])) return;
                
                for(var i = 0, func; func = tableCache[tblId]["callbacks"][cback][i]; i++) {                         
                        func(opts || {});
                };
        };
            
        var buildSelectList = function(select, tableId, startPos, endPos) {
                var comparison          = tableCache[tableId].filterType[startPos].comparison,
                    dataType            = tableCache[tableId].filterType[startPos].dataType,
                    currentFilter       = String(tableCache[tableId].filterList[startPos]),
                    numFilters          = 0,
                    dataObj             = tableCache[tableId].rowData,
                    newArray            = [],
                    txtObj              = {},
                    data, tr;
                
                for(fltr in tableCache[tableId].filterList) {
                        if(tableCache[tableId].filterList[fltr] != "" && startPos != fltr) numFilters++;
                        if(numFilters > 1) break;
                };
                
                for(var i = 0, row; row = dataObj[i]; i++) {
                        tr = row.trNode;                         
                        
                        if(numFilters > 0 && tr.className.search(/invisibleRow/) != -1) continue;
                        
                        for(var r = startPos; r < endPos; r++) { 
                                
                                data = row.columnData[r];
                                if(data[1] != "" && !(data[1] in txtObj)) {
                                        newArray.push(data);
                                        txtObj[data[1]] = data[0];
                                };
                        };
                };

                newArray.sort(comparison == "numeric" ? sortNumeric : sortText);

                select.options.length = 0;

                opt = new Option("","");
                select.options[0] = opt;
                
                for(var i = 0, txt; txt = newArray[i]; i++) {
                        opt = new Option(txt[1],txt[0]);
                        if((i+1) & 1) { opt.className = "alternative"; };
                        if(currentFilter === String(txt[0])) { opt.selected = true; };
                        select.options[i+1] = opt;
                };
        }; 
        var popUpFilter = function(e) {
                clearTimeout(delayedTimer);
                embedded = false;
                filterData = this.tagName == "FORM" ? this.getElementsByTagName("input")[0].value : this.options[this.selectedIndex].value;
                filter();
                removeDocumentEvent();
                return stopDOMEvent(e || window.event);
        };
        var embeddedFilter = function(e) { 
                clearTimeout(delayedTimer); 
                embedded = true;                  
                var parts = this.id.replace(/^form-/, "").split("-");
                currentTableId = parts[0];
                colRangeStart  = Number(parts[1]);
                colRangeFinish = Number(parts[2]);
                filterData     = this.tagName.toUpperCase() == "FORM" ? this.getElementsByTagName("input")[0].value : this.options[this.selectedIndex].value;
                
                filter();                     
                
                return stopDOMEvent(e || window.event);
        };
        var updateEmbeddedSelectList = function(e) {                  
                clearTimeout(delayedTimer);                   
                var parts = this.id.replace(/^form-/, "").split("-");                 
                buildSelectList(this, parts[0], Number(parts[1]), Number(parts[2]));                 
                return true;                     
        };
        var jsFilter = function(tableId, startPos, finish, filter) {
                if(!tableId || !(tableId in tableCache)) { return false; };
                embedded       = true;
                currentTableId = tableId;
                colRangeStart  = startPos;
                colRangeFinish = finish;
                filterData     = filter;
                filter();
                return true;
        };           
        var delayedFilter = function(e) {
                clearTimeout(delayedTimer);
                var tmp = this;               
                              
                delayedTimer = setTimeout(function() { 
                        if(tmp.className.search('fdFilter-') != -1) {
                                var parts      = tmp.id.split("-");
                                currentTableId = parts[0];
                                colRangeStart  = Number(parts[1]);
                                colRangeFinish = Number(parts[2]);
                                embedded       = true;
                        } else {
                                embedded       = false;
                        };
                        filterData     = tmp.value;
                        filter(); }, keyTimer);        
        };
              
        var clearFilter = function(tableId) {
                if(!tableId || !(tableId in tableCache) || !document.getElementById(tableId)) { return; };
                currentTableId = tableId;
                filterData     = "";

                var m,
                    cnt         = 0,
                    popup       = document.getElementById(tableId).className.search(/popup-filter/) != -1,
                    colStart    = false;
                
                for(f in tableCache[tableId].filterList) {
                        if(tableCache[tableId].filterList[f]) {
                                tableCache[tableId].filterList[f] = "";
                                if(colStart === false) { colStart = f; };
                        };
                };
                
                if(colStart === false) { return; };
                
                if(popup) {
                        var thNodes = document.getElementById(tableId).getElementsByTagName('th');
                        for(var i = 0, thNode; thNode = thNodes[i]; i++) {
                                m = thNode.className.match(/fdFilterProcessed-([\d]+)-([\d]+)/);
                                if(!m) continue;

                                var lnks = thNode.getElementsByTagName('a');
                                for(var z = 0, a; a = lnks[z];z++) {
                                        if(a.className.search("fdFilterUsed") != -1) {
                                                removeClassName(a, "fdFilterUsed");
                                                break;
                                        };
                                };
                        };
                } else {
                        var inputs  = document.getElementById(tableId).getElementsByTagName('input'),
                            selects = document.getElementById(tableId).getElementsByTagName('select');
                        for(var i = 0, elem; elem = inputs[i]; i++) {
                                if(elem.className.search(/fdFilter-/) == -1) { continue; };
                                elem.value = "";
                        };
                        for(var i = 0, elem; elem = selects[i]; i++) {
                                if(elem.className.search(/fdFilter-/) == -1) { continue; };
                                elem.selectedIndex = 0;
                        };
                };
                
                colRangeStart     = colStart || 0;
                colRangeFinish    = parseInt(colStart, 10) + 1;
                filter(true);
        };
        
        var filter = function(force) {

                if(!currentTableId) { return; };
                
                function testValue(operator, value1, value2) {
                        switch(operator) {
                                case "<=":
                                        return !(value1 <= value2);                                        
                                case ">=":
                                        return !(value1 >= value2);
                                case "<":
                                        return value1 >= value2;
                                case ">":
                                        return value1 <= value2;
                                case "!":
                                        return value1 == value2;
                                default:
                                        return String(value1) != String(value2);
                        };                       
                };
                
                function testRegExp(testValue, cellData) {                         
                        var regexp = new RegExp(regExpEscape(testValue),"gi");
                        return (!regexp.test(cellData));                         
                };
                
                var dataType    = tableCache[currentTableId].filterType[colRangeStart].dataType,
                    comparison  = tableCache[currentTableId].filterType[colRangeStart].comparison,
                    useList     = tableCache[currentTableId].filterType[colRangeStart].useList,
                    dataObj     = tableCache[currentTableId].rowData,
                    rowStyle    = tableCache[currentTableId].rowStyle,
                    rowLen      = dataObj.length,
                    origVal     = filterData,
                    val         = origVal,
                    operator    = !useList && val.search(/^(<=|>=|<|>|!)/) != -1 ? val.match(/^(<=|>=|<|>|!)/)[1] : "",
                    preparedVal = "",
                    visibleRows = [],
                    hideRow, f, cellData, regexp, filter;                  
                
                if(operator && !useList) { val = val.replace(/^(<=|>=|<|>|!)/, "").replace(/^\s\s*/, ""); };
               
                if(val && !useList) {
                        if(dataType.search(/^(date|datedmy)$/) != -1) {
                                preparedVal = dateFormat(val, dataType.indexOf("dmy") != -1);
                                if(preparedVal == 0) { preparedVal = ""; };
                        } else if(dataType == "numeric") {
                                preparedVal = parseFloat(val.replace(/[^0-9\.\-]/g,''));
                        } else if(dataType in window && typeof(window[dataType]) == "function") {
                                preparedVal = window[dataType](null, val);
                        } else {
                                preparedVal = val.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
                        };
                } else if(useList) {
                        preparedVal = val;
                };

                if(a && a.tagName) {
                        if(val.replace(/^\s\s*/, '').replace(/\s\s*$/, '') != "") {
                                addClassName(a, "fdFilterUsed");
                        } else {
                                removeClassName(a, "fdFilterUsed");
                        };
                };

                for(var i = colRangeStart; i < colRangeFinish; i++) {
                        tableCache[currentTableId].filterList[i] = origVal;
                        tableCache[currentTableId].filterPrep[i] = preparedVal;
                        tableCache[currentTableId].filterMath[i] = operator;
                };

                for(var i = 0, row; row = dataObj[i]; i++) {
                        hideRow = false;

                        if(!force) {
                                for(f in tableCache[currentTableId].filterList) {
                                        origValue       = tableCache[currentTableId].filterList[f];
                                        if(origValue == "" ) { continue; };
                                
                                        prepValue       = tableCache[currentTableId].filterPrep[f];
                                        mathOperator    = tableCache[currentTableId].filterMath[f];
                                        dataType        = tableCache[currentTableId].filterType[f].dataType;
                                        comparison      = tableCache[currentTableId].filterType[f].comparison;
                                        useList         = tableCache[currentTableId].filterType[f].useList;
                                        cellData        = row.columnData[f][0];

                                        if(useList) {
                                                if(cellData != origValue) {
                                                        hideRow = true;
                                                        break;
                                                };
                                                continue;
                                        };

                                        if(dataType.search(/^(datedmy|date)$/) != -1 && /^\d\d\d\d$/.test(prepValue)) {
                                                cellData = String(cellData).substr(0,4);                                                                                               
                                        };

                                        if(comparison == "numeric" && (isNaN(prepValue) || String(prepValue) == "" || isNaN(cellData) || String(cellData) == "")) {
                                                continue;
                                        };
                                
                                        if(comparison == "numeric" || mathOperator) {                                                                                             
                                                if(testValue(mathOperator, cellData, prepValue)) {
                                                        hideRow = true;
                                                        break;
                                                };
                                        } else if(testRegExp(prepValue, cellData)) {
                                                hideRow = true;
                                                break;
                                        };
                                };
                        };
                        
                        if(hideRow) {
                                addClassName(row.trNode, "invisibleRow");
                        } else {
                                visibleRows[visibleRows.length] = row.trNode;
                                if(rowStyle) { removeClassName(row.trNode, rowStyle); };
                                removeClassName(row.trNode, "invisibleRow");
                        };
                };
                
                if("tablePaginater" in window && tablePaginater.tableIsPaginated(currentTableId)) {
                        tablePaginater.init(currentTableId);
                } else if(rowStyle) {
                        zebraStripe(currentTableId, rowStyle);
                };                  
                
                if(embedded && visibleRows.length) {
                        for(f in tableCache[currentTableId].filterList) {                                                            
                                if(tableCache[currentTableId].filterType[f].useList) {
                                        buildSelectList(tableCache[currentTableId].filterType[f].selectListRef, currentTableId, tableCache[currentTableId].filterType[f].colStart, tableCache[currentTableId].filterType[f].colEnd);                                     
                                };                
                        };
                };
                
                callback(currentTableId, "filter", {"tableId":currentTableId, "visibleRows":visibleRows});
        };
        
        var zebraStripe = function(tableId, rowStyle) {
                var tbl         = document.getElementById(tableId),
                    tbody       = tbl.getElementsByTagName("tbody"),
                    hook        = tbody && tbody.length ? tbody[0] : tbl,
                    trs         = hook.rows,
                    len         = trs.length,
                    rowCnt      = 0,
                    reg         = /(^|\s)invisibleRow(\s|$)/;
                
                for(var i = 0; i < len; i++) {
                        if(trs[i].className.search(reg) != -1 || trs[i].parentNode.tagName == "TFOOT") { continue; };
                        if(rowCnt++ & 1) {
                                addClassName(trs[i], rowStyle);
                        } else {
                                removeClassName(trs[i], rowStyle);
                        };
                };
        };
        
        var showFilter = function(e) {
                
                timer = null;
                
                e = e || window.event;
                var kc = e.type == "keypress" ? e.keyCode != null ? e.keyCode : e.charCode : -1;

                if(e.type == "keypress" && kc != 13) { return true; };
        
                var targ = this;
                while(targ.tagName.toLowerCase() != "a") { targ = targ.parentNode; };
                var aTmp = targ;
                while(targ.tagName.toLowerCase() != "th") { targ = targ.parentNode; };
                var thNodeTmp = targ;
                while(targ.tagName.toLowerCase() != "table") { targ = targ.parentNode; };
                var table = targ;   
                
                var m = thNodeTmp.className.match(/fdFilterProcessed-([\d]+)-([\d]+)/);
                
                colRangeStart     = Number(m[1]);
                colRangeFinish    = Number(m[2]);
                currentTableId    = table.id;
                thNode            = thNodeTmp;
                a                 = aTmp;                  
                embedded          = false;
                
                var useList                     = tableCache[table.id].filterType[colRangeStart].useList,
                    currentFilter               = tableCache[table.id].filterList[colRangeStart],
                    dataObj                     = tableCache[table.id].rowData,
                    wrapper                     = document.getElementById("fdTablefilterWrapper"),
                    input                       = wrapper.getElementsByTagName("input")[0],
                    select                      = wrapper.getElementsByTagName("select")[0],
                    tlc                         = document.getElementById("fdtl"),
                    dongle                      = document.getElementById("fddongle");

                if(useList) {
                        select.options.length   = 0;
                        buildSelectList(select, currentTableId, colRangeStart, colRangeFinish);
                        select.style.display    = "";
                        input.style.display     = "none";
                } else {
                        input.value             = currentFilter || "";
                        select.style.display    = "none";
                        input.setAttribute("maxlength", tableCache[table.id].maxLength[colRangeStart] + 2);
                        if(tableCache[table.id].numberOfRows < maxRows && table.className.search('no-keypress-filter') == -1) { input.onkeyup = delayedFilter; }
                        else { input.onkeyup = null; };                         
                        input.style.display     = "";
                };
                
                wrapper.style.visibility        = "hidden";
                wrapper.style.display           = "block";

                var cw = tlc.offsetWidth,
                    w  = Math.max(thNode.offsetWidth, 100);

                wrapper.style.width     = (w + (2 * cw)) + "px";
                
                var pos           = truePosition(thNode);
                pos[0] -= (((w + (2 * cw)) - thNode.offsetWidth) / 2);
                
                var trueBody      = (document.compatMode && document.compatMode!="BackCompat") ? document.documentElement : document.body,
                    scrollTop     = window.devicePixelRatio || window.opera ? 0 : trueBody.scrollTop,
                    scrollLeft    = window.devicePixelRatio || window.opera ? 0 : trueBody.scrollLeft;

                if(parseInt(trueBody.clientWidth+scrollLeft) < parseInt(w+pos[0])) {
                        wrapper.style.left = Math.abs(parseInt((trueBody.clientWidth+scrollLeft) - w)) + "px";
                } else {
                        wrapper.style.left  = pos[0] + "px";
                };

                wrapper.style.top   = Math.abs(parseInt(pos[1] + thNode.offsetHeight - 4)) + "px";
                
                addDocumentEvent();

                wrapper.style.visibility = "visible";

                dongle.style.left = (w / 2) + "px";
                
                try { useList ? select.focus() : input.focus(); } catch(err) {};
                
                return stopDOMEvent(e || window.event);
        };
        
        var checkDocumentEvent = function(e) {
                e = e || document.parentWindow.event;
                var el = e.target != null ? e.target : e.srcElement,
                    found = false;
                    
                while(el.parentNode) {
                        if(el.id && el.id == "fdTablefilterWrapper") {
                                found = true;
                                break;
                        };
                        try { el = el.parentNode; } catch(err) { break; };
                };
                if(!found) {
                        removeDocumentEvent();
                        return stopDOMEvent(e);
                };
        };
        var addDocumentEvent = function() {
                addDOMEvent(document, "mousedown", checkDocumentEvent);
        };
        var removeDocumentEvent = function() {
                removeDOMEvent(document, "mousedown", checkDocumentEvent);
                var wrap                = document.getElementById("fdTablefilterWrapper");
                wrap.style.visibility   = "hidden";
                wrap.style.display      = "none";
                colRangeStart = colRangeFinish = currentTableId = thNode = a = null;
        };
        var removeTableCache = function(table) {
                if(!(table.id in tableCache)) return;

                tableCache[table.id] = null;
                delete tableCache[table.id];

                if(table.className.search(/popup-filter/) != -1) {
                        var ths = table.getElementsByTagName("th"),
                            lnks;
                        for(var i = ths.length; i--;) {
                                lnks = ths[i].getElementsByTagName("a");
                                for(var z = lnks.length; z--;) {
                                        if(lnks[z].className.search(/fdFilterTrigger|fdFilterUsed/) != -1) {                                                
                                                lnks[z].parentNode.removeChild(lnks[z]);
                                        };
                                };
                        };
                        ths = lnks = null;
                } else {
                        var trs = table.getElementsByTagName("tr");
                        for(var i = 0, tr; tr = trs[i]; i++) {
                                if(tr.className == "fdFilterTableRow") {
                                        tr.parentNode.removeChild(tr);
                                        break;
                                };
                        };
                        trs = null;                        
                };
        };
        var regExpEscape = function(s){
                function escape(e) {
                        a = new RegExp('\\'+e,'g');
                        s = s.replace(a,'\\'+e);
                };
                var chars = ['\\','[','^','$','.','|','?','*','+','(',')'];
                for(e in chars) { escape(chars[e]); };
                escape = null;
                return s;
        };
        var getInnerText = function(el) {
                if (typeof el == "string" || typeof el == "undefined") return el;
                if(el.innerText) return el.innerText;
                var txt = '', i;
                for(i = el.firstChild; i; i = i.nextSibling) {
                        if(i.nodeType == 3)            txt += i.nodeValue;
                        else if(i.nodeType == 1)       txt += getInnerText(i);
                };
                return txt;
        };
        var unLoad = function(e) {
                for(tbl in tableCache) {
                        removeTableCache(document.getElementById(tbl));
                };
                delete(tableCache);                
                var wrapper = document.getElementById("fdTablefilterWrapper");
                if(wrapper) { wrapper.parentNode.removeChild(wrapper); wrapper = null; };
        };
        var buildScaffold = function() {
                if(document.getElementById("fdTablefilterWrapper")) { return; };
                
                var div         = document.createElement("div"),
                    form        = document.createElement("form"),
                    p           = document.createElement("p"),
                    inp         = document.createElement("input"),
                    sel         = document.createElement("select"),
                    c           = ["fdtl","fdtr","fdbl","fdbr"],
                    bs1         = ["fdlb", "fdrb"],
                    bs2         = ["fdtb", "fdbb"],
                    w, h, m, wrap, corner, bar;
                    
                wrap = div.cloneNode(false);
                wrap.id = "fdTablefilterWrapper";
                
                form.action     = "";
                form.method     = "post";
                form.onsubmit   = popUpFilter;

                var input = inp.cloneNode(true);
                input.type = "text";
                input.name = input.id = "fdFilterInp";
                
                sel.name = sel.id = "fdFilterSel";
                sel.onchange = popUpFilter;

                p.appendChild(sel);
                p.appendChild(input);
                
                form.appendChild(p);
                
                wrap.appendChild(form);
                
                for(var i = 0; i < 4; i++) {
                        corner = div.cloneNode(false);
                        corner.id = c[i];
                        wrap.appendChild(corner);
                        corner = null;
                };

                for(i = 0; i < 2; i++) {
                        bar = div.cloneNode(false);
                        bar.id = bs1[i];
                        wrap.appendChild(bar);
                        bar = null;
                };

                for(i = 0; i < 2; i++) {
                        bar = div.cloneNode(false);
                        bar.id = bs2[i];
                        wrap.appendChild(bar);
                        bar = null;
                };
                
                var dongle = div.cloneNode(false);
                dongle.id = "fddongle";
                wrap.appendChild(dongle);
                
                wrap.style.left = wrap.style.top = "-1000em";

                wrap.style.visibility = "visible";
                wrap.style.display = "";
                
                timer = setTimeout(removeDocumentEvent, 200);
                
                document.getElementsByTagName("body")[0].appendChild(wrap);
        };
        var addDOMEvent = function(obj, type, fn) {
                if( obj.attachEvent ) {
                        obj["e"+type+fn] = fn;
                        obj[type+fn] = function(){obj["e"+type+fn]( window.event );};
                        obj.attachEvent( "on"+type, obj[type+fn] );
                } else {
                        obj.addEventListener( type, fn, true );
                };
        };
        var removeDOMEvent = function(obj, type, fn) {
                try {
                        if( obj.detachEvent ) {
                                obj.detachEvent( "on"+type, obj[type+fn] );
                                obj[type+fn] = null;
                        } else {
                                obj.removeEventListener( type, fn, true );
                        };
                } catch(err) {};
        };
        var stopDOMEvent = function(e) {
                e = e || window.event;
                if(e.stopPropagation) {
                        e.stopPropagation();
                        e.preventDefault();
                };
                /*@cc_on@*/
                /*@if(@_win32)
                e.cancelBubble = true;
                e.returnValue  = false;
                /*@end@*/
                return false;
        };
        var dateFormat = function(dateIn, favourDMY) {
                if(/^(\d\d\d\d)$/.test(dateIn)) return String(dateIn);
                
                var dateTest = [
                        { regExp:/^(0?[1-9]|1[012])([- \/.])(0?[1-9]|[12][0-9]|3[01])([- \/.])((\d\d)?\d\d)$/, d:3, m:1, y:5 },  // mdy
                        { regExp:/^(0?[1-9]|[12][0-9]|3[01])([- \/.])(0?[1-9]|1[012])([- \/.])((\d\d)?\d\d)$/, d:1, m:3, y:5 },  // dmy
                        { regExp:/^(\d\d\d\d)([- \/.])(0?[1-9]|1[012])([- \/.])(0?[1-9]|[12][0-9]|3[01])$/, d:5, m:3, y:1 }      // ymd
                        ],
                    start,
                    cnt = 0;
                    numFormats = dateTest.length;
                    
                while(cnt < numFormats) {
                        start = (cnt + (favourDMY ? numFormats + 1 : numFormats)) % numFormats;
                        if(dateIn.match(dateTest[start].regExp)) {
                                res = dateIn.match(dateTest[start].regExp);
                                y = res[dateTest[start].y];
                                m = res[dateTest[start].m];
                                d = res[dateTest[start].d];
                                if(m.length == 1) m = "0" + String(m);
                                if(d.length == 1) d = "0" + String(d);
                                if(y.length != 4) y = (parseInt(y) < 50) ? "20" + String(y) : "19" + String(y);

                                return y+String(m)+d;
                        };
                        cnt++;
                };
                return 0;
        };
        var sortNumeric = function(a,b) {
                var aa = a[0],
                    bb = b[0];
                if(aa == bb) return 0;
                if(aa === "" && !isNaN(bb)) return -1;
                if(bb === "" && !isNaN(aa)) return 1;
                return aa - bb;
        };
        var sortText = function(a,b) {
                var aa = a[0],
                    bb = b[0];
                if(aa == bb) return 0;
                if(aa < bb)  return -1;
                return 1;
        };
        var truePosition = function(element) {
                var pos = cumulativeOffset(element);
                if(window.opera) { return pos; }
                var iebody      = (document.compatMode && document.compatMode != "BackCompat")? document.documentElement : document.body,
                    dsocleft    = document.all ? iebody.scrollLeft : window.pageXOffset,
                    dsoctop     = document.all ? iebody.scrollTop  : window.pageYOffset,
                    posReal     = realOffset(element);
                    
                return [pos[0] - posReal[0] + dsocleft, pos[1] - posReal[1] + dsoctop];
        };
        var realOffset = function(element) {
                var t = 0, l = 0;
                do {
                        t += element.scrollTop  || 0;
                        l += element.scrollLeft || 0;
                        element = element.parentNode;
                } while (element);
                return [l, t];
        };
        var cumulativeOffset = function(element) {
                var t = 0, l = 0;
                do {
                        t += element.offsetTop  || 0;
                        l += element.offsetLeft || 0;
                        element = element.offsetParent;
                } while (element);
                return [l, t];
        };        
        var addClassName = function(e,c) {
                if(new RegExp("(^|\\s)" + c + "(\\s|$)").test(e.className)) return;
                e.className += ( e.className ? " " : "" ) + c;
        }; 
        /*@cc_on
        /*@if (@_win32)
        var removeClassName = function(e,c) {                 
                e.className = !c ? "" : e.className.replace(new RegExp("(^|\\s)" + c + "(\\s|$)"), " ").replace(/^\s*((?:[\S\s]*\S)?)\s*$/, '$1');                
        };
        @else @*/
        var removeClassName = function(e,c) {                 
                e.className = !c ? "" : (e.className || "").replace(new RegExp("(^|\\s)" + c + "(\\s|$)"), " ").replace(/^\s\s*/, '').replace(/\s\s*$/, '');
        };
        /*@end
        @*/   
        
        addDOMEvent(window, "load",   init);
        addDOMEvent(window, "unload", unLoad);  
        
        return {
                initFilter:             function(tableId, startPos, finish, filter) { return jsFilter(tableId, startPos, finish, filter); },
                prepareTable:           function(tableId) { init(tableId); },
                clearTableFilter:       function(tableId) { clearFilter(tableId); },
                getNodeInnerText:       function(node) { return getInnerText(node); },
                addEvent:               function(node, evt, func) { return addDOMEvent(node, evt, func); },
                removeEvent:            function(node, evt, func) { return removeDOMEvent(node, evt, func); },
                stopEvent:              function(e) { return stopDOMEvent(e); },
                addClass:               function(e,c) { addClassName(e,c); },
                removeClass:            function(e,c) { removeClassName(e,c); },
                removeOnLoadEvent:      function() { removeDOMEvent(window, "load", init); },
                setMaxRows:             function(max) { maxRows = max; },
                setKeyDelay:            function(delay) { keyTimer = delay; }
        }; 
})();