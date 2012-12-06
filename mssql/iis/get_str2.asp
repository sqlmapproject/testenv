<%
  Dim ame, objRS, strSQL

  name = Request.QueryString("name")

  strSQL = "SELECT * FROM users WHERE name='" + name + "'"

  Set objRS = Server.CreateObject("ADODB.Recordset")
  objRS.Open strSQL, "Provider=SQLOLEDB; Data Source = (local); Initial Catalog = master; User Id = sa; Password="

  If (objRS.EOF) Then
    Response.Write "Invalid login."
  Else
    Response.Write "You are logged in as " & objRS("name")
  End If

  Set objRS = Nothing
%>
