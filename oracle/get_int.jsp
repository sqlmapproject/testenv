<%@ page import="java.sql.*" %>
<HTML>
<HEAD><TITLE>Simple JSP/Oracle Query Example</TITLE></HEAD>
<BODY BGCOLOR="#FFFFFF">
<CENTER>
<B>Employees</B>
<BR><BR>


<%
      Connection conn = null;
try
    {
	String id = request.getParameter("id");
	Class.forName("oracle.jdbc.driver.OracleDriver");
	conn = DriverManager.getConnection(
					   "jdbc:oracle:thin:@localhost:1521:XE",
					   "SYS AS SYSDBA",
					   "oracle");
	String sql = "SELECT * FROM customers";

	if (id != null) {
	    sql += " WHERE id = " + id;
	}

	out.println(sql);

	
	/* PreparedStatement stmt = conn.createStatement();*/
	PreparedStatement stmt = conn.prepareStatement(sql);
	ResultSet rs = stmt.executeQuery();


	
	out.println("<TABLE CELLSPACING=\"0\" CELLPADDING=\"3\" BORDER=\"1\">");
	out.println("<TR><TH>ID</TH><TH>NAME</TH><TH>PASSWORD</TH>"); 

	//Loop through results of query.

	while(rs.next())

	    {
		out.println("<TR>");
		out.println("<TD>" + rs.getInt("id") + "</TD>");
		out.println(" <TD>" + rs.getString("name") + "</TD>");
		out.println(" <TD>" + rs.getString("password") + "</TD>");
		out.println("</TR>");
	    }

	out.println("</TABLE>");

    }
catch(SQLException e)
    {

	out.println("SQLException: " + e.getMessage() + "<BR>");
	while((e = e.getNextException()) != null)
	    out.println(e.getMessage() + "<BR>");

    }

catch(ClassNotFoundException e)

    {
	out.println("ClassNotFoundException: " + e.getMessage() + "<BR>");
    }
finally
    {
	//Clean up resources, close the connection.
	if(conn != null)
	    {
		try
		    {
			conn.close();
		    }
		catch (Exception ignored) {}
	    }
    }

%>

</CENTER>
</BODY>
</HTML>
