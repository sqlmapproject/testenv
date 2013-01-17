<%
Option Explicit
' Dimension Local variables
Dim objConn         
Dim objRS          
Dim strDSN         
Dim strSQL         
Dim intTotalColumns
Dim intCounter
Dim name

' Set the ADO Constants if you are not including
' the adovbs.inc file
Const adOpenStatic  = 3
Const adLockReadOnly = 1

Set objConn = Server.CreateObject("ADODB.Connection")
Set objRS  = Server.CreateObject("ADODB.Recordset")

strDSN = "Driver={SQL Server};Server=127.0.0.1;Database=testdb;UID=sa;PWD=testpass"

objConn.Open strDSN

name = Request.QueryString("name")
//strSQL = "SELECT * FROM users WHERE id = '" + id + "'"
strSQL = "FindRecord """ + name + """"

objRS.Open strSQL, objConn, adOpenStatic,adLockReadOnly

' get the total number of columns
intTotalColumns = objRS.Fields.Count - 1
%>
 <TABLE BORDER="1" WIDTH="500">
  <tr>
  <%
  ' first display the column names
  For intCounter = 0 To intTotalColumns
  %>
   <TD>
    <B><%=objRS(intCounter).Name%></B>
   </TD>
  <%
  Next
  
  Response.write "</TR>"
  
  ' now loop through the recordset and display the data
  Do Until objRS.EOF = True
     
   Response.Write "<TR>"
   For intCounter = 0 To intTotalColumns
   
    Response.Write "<td width=100 align=center>"
    Response.write objRS(intCounter).Value
    Response.Write "</TD>"
    
   Next
   Response.Write "</TR>"
      
  objRS.Movenext
  Loop
 %>
</TABLE>
<%

' Close Recordset
objRS.Close
Set objRS = Nothing

objConn.Close
Set objConn = Nothing
%>
