package cz.jcbo.csju;

import java.io.IOException;
import java.net.MalformedURLException;
import java.sql.SQLException;
import java.util.Date;
import java.util.List;

import com.gargoylesoftware.htmlunit.FailingHttpStatusCodeException;
import com.gargoylesoftware.htmlunit.Page;
import com.gargoylesoftware.htmlunit.WebClient;
import com.gargoylesoftware.htmlunit.css.StyleElement;
import com.gargoylesoftware.htmlunit.html.DomNode;
import com.gargoylesoftware.htmlunit.html.DomNodeList;
import com.gargoylesoftware.htmlunit.html.HtmlElement;
import com.gargoylesoftware.htmlunit.html.HtmlForm;
import com.gargoylesoftware.htmlunit.html.HtmlInput;
import com.gargoylesoftware.htmlunit.html.HtmlPage;
import com.gargoylesoftware.htmlunit.html.HtmlTable;
import com.gargoylesoftware.htmlunit.html.HtmlTableCell;
import com.gargoylesoftware.htmlunit.html.HtmlTableRow;

import cz.jcbo.model.Judoka;
import cz.jcbo.service.DBConnection;
import cz.jcbo.service.JudokaService;
import junit.framework.Assert;

/**
 * Hello world!
 *
 */
public class BulkDump 
{
	private String URL = "https://evidence.czechjudo.org/EasyUsers.aspx";
	
	public void run( String[] args ) throws FailingHttpStatusCodeException, MalformedURLException, IOException, SQLException
	{
		System.out.println( "Import start!" );
		//final WebClient webClient = new WebClient();
	    try (final WebClient webClient = new WebClient()) 
	    {
	    	DBConnection dbc = new DBConnection();
	    	JudokaService srvr = new JudokaService(dbc);
	    	
	    	// main page
	        final HtmlPage page = webClient.getPage(URL);
	        //Assert.assertEquals("HtmlUnit - Welcome to HtmlUnit", page.getTitleText()); // nema title

	        // select 1jcbo only
	        List<HtmlForm> forms = page.getForms();
	        Assert.assertTrue(forms.size() > 0);
	        HtmlForm form = forms.get(0);
	        HtmlInput klub = form.getInputByName("ctl00$cphMain$txtClub"); // id = ctl00_cphMain_txtClub
	        klub.setValueAttribute("1. Judo Club Baník Ostrava"); // 1. Judo Club Baník Ostrava
	        klub = form.getInputByName("ctl00$cphMain$hiddenClubId"); // id = ctl00_cphMain_hiddenClubId
	        klub.setValueAttribute("694");
	        
	        // result page
	        int pageNo = 1;
	        HtmlPage resp = form.getInputByName("ctl00$cphMain$imgBtnRefresh").click();
	        HtmlTable table = resp.getHtmlElementById("ctl00_cphMain_GridViewUsers");

	        loops:
	        for (final HtmlTableRow row : table.getRows()) 
	        {
	        	StyleElement st = row.getStyleElement("background-color"); // LightGreen
	        	
	            System.out.println("Found row, st=" + st); //(st == null ? "-null-" : st.getValue()));
	            int cno = 1;
	            // na konci tabule je next page jumper, a je v dalsi tabuli (idioti)
	            if (st == null || st.getValue().length() == 0) //asi je empty
	            {
	            	DomNodeList<HtmlElement> elemz =  row.getElementsByTagName("a");
	            	String jehla = "Page$" + (pageNo+1);
	            	for (HtmlElement he : elemz)
	            	{
	            		if (he.getAttribute("href").contains(jehla))
	            		{
	            			System.out.println(" ... tu kliknem! " + he);
	            			pageNo++;
	            			resp = he.click();
            				ihawdfjk;
	            		}
	            	}
	            	
	            	Object x = row.getCell(0).getFirstByXPath("a");
	            	System.out.println("ende: " + elemz.size() + "; " + x);
	            }
                Judoka j = new Judoka(); 
	            for (final HtmlTableCell cell : row.getCells()) {
	                System.out.print("   Found cell ("+cno+"): " + cell.asText());
	                if (cno== 1 && st.getValue().equalsIgnoreCase("LightGreen"))
	                {
	                	DomNodeList<HtmlElement> kids = cell.getElementsByTagName("a");
	                	if (kids.size() > 0)
	                	{
	                		Page in = kids.get(0).click();
	                		java.net.URL url = in.getUrl();
	                		System.out.print("; cls = "+in.getClass().getName()+"; url = " + in.getUrl() + "; file = " + url.getFile() + "; path = " + url.getPath()); 
	                		String csuidstr = url.getPath().substring( url.getPath().lastIndexOf('=') );
	                		try {
	                			int csuid = Integer.valueOf(csuidstr);
	                			j.setCSJUId(csuid);
	                		} catch (Exception e)
	                		{
	                			// nop
	                		}
	                	}
	                }
	                switch (cno)
	                {
	                case 1:
	                	j.setSurname(cell.asText());
	                	if (st.getValue().equalsIgnoreCase("LightGreen")) j.setStatus('A');
	                	if (st.getValue().equalsIgnoreCase("Transparent")) j.setStatus('T');
	                	if (st.getValue().equalsIgnoreCase("#DDDDDD")) j.setStatus('I');
	                	break;
	                case 2:
	                	j.setName(cell.asText());
	                	break;
	                case 3:
		                try { 
		                	int year = Integer.valueOf(cell.asText());
		                	j.setBirthDate(new Date(year, 1, 1));
		                	break;
		                } catch (Exception e)
		                {
		                	
		                }
	                }
	                System.out.println();
	                
	                cno++;
	            } // end for cells
                if (j.getName() != null) srvr.store(j);
	        } // end for rows
	    }
	}
	//judoka
	
    public static void main( String[] args ) throws Exception
    {
        new BulkDump().run(args);
    }
}
