<%
Dim sConnection, objConn , objRS

sConnection = "DRIVER={MySQL ODBC 5.1 Driver}; SERVER=localhost; DATABASE=testdb; UID=root;PASSWORD=testpass; OPTION=3; PORT=3306"

Set objConn = Server.CreateObject("ADODB.Connection")

objConn.Open(sConnection)

id = Request.QueryString("id")
strSQL = "SELECT * FROM users WHERE id = " + id

Set objRS = objConn.Execute(strSQL)


While Not objRS.EOF
Response.Write objRS.Fields("name") & ", " & objRS.Fields("surname") & "<br>"
objRS.MoveNext
Wend

objRS.Close
Set objRS = Nothing
objConn.Close
Set objConn = Nothing
%> 
