<%
Dim sConnection, objConn , objRS

sConnection = "DRIVER={PostgreSQL ANSI}; SERVER=localhost; DATABASE=testdb; UID=postgres; PASSWORD=testpass; PORT=5433"

Set objConn = Server.CreateObject("ADODB.Connection")

objConn.Open(sConnection)

id = Request.QueryString("id")
strSQL = "SELECT * FROM users WHERE id = " + id

Set objRS = objConn.Execute(strSQL)


While Not objRS.EOF
Response.Write objRS.Fields("username") & ", " & objRS.Fields("password") & "<br>"
objRS.MoveNext
Wend

objRS.Close
Set objRS = Nothing
objConn.Close
Set objConn = Nothing
%> 
