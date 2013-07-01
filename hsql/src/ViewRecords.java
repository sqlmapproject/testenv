
import java.io.IOException;
import java.io.PrintWriter;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.util.HashMap;

public class ViewRecords extends HttpServlet {
	Connection con;
	
	@Override
	public void init() throws ServletException {
		try {
			Class.forName("org.hsqldb.jdbcDriver");
		} catch (ClassNotFoundException e) {
			e.printStackTrace(System.out);
		}
		try {
			con=DriverManager.getConnection("jdbc:hsqldb:hsqldb-1_7_2","SA","");
		} catch (SQLException e) {
			e.printStackTrace(System.out);
		}
		
		HashMap methods = new HashMap();
		methods.put("str", "select * from contacts where name='%s'");
		methods.put("int_groupby", "SELECT * FROM contacts GROUP BY %s");
		methods.put("int_orderby", "SELECT * FROM contacts ORDER BY %s");
		methods.put("int_inline", "%s");
	}
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		response.setContentType("text/html");
		PrintWriter out=response.getWriter();
		try {
			String inject = request.getParameter("inject");
			String method = request.getParameter("method");
			
			String query = String.format(methods.get(method), inject);
			
			ResultSet rs =con.createStatement().executeQuery(query);
			while(rs.next()){
				out.write("<br/>"+rs.getString(1));
				out.write(", "+rs.getString(2));
				out.write(", "+rs.getString(3));
			}
			out.write("<hr/><a href='index.html'>Home</a> ");
		} catch (SQLException e) {
			throw new ServletException(e);
		}
	}

}
