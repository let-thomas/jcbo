package cz.jcbo.csju;

import java.io.IOException;
import java.sql.SQLException;
import java.util.Calendar;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;

import com.gargoylesoftware.htmlunit.History;
import com.gargoylesoftware.htmlunit.Page;
import com.gargoylesoftware.htmlunit.css.StyleElement;
import com.gargoylesoftware.htmlunit.html.DomNodeList;
import com.gargoylesoftware.htmlunit.html.HtmlElement;
import com.gargoylesoftware.htmlunit.html.HtmlPage;
import com.gargoylesoftware.htmlunit.html.HtmlTable;
import com.gargoylesoftware.htmlunit.html.HtmlTableCell;
import com.gargoylesoftware.htmlunit.html.HtmlTableRow;

import cz.jcbo.model.Judoka;
import cz.jcbo.service.DBConnection;
import cz.jcbo.service.JudokaService;

public abstract class Common {

	protected String URL = "https://evidence.czechjudo.org/EasyUsers.aspx";
	protected JudokaService mService = null;
	protected final Pattern mPattern = Pattern.compile("id=(\\d+)");
	private static final Log LOG = LogFactory.getLog(Common.class);

	public Common() {
		super();
	}

	abstract void run(String[] args) throws Exception;
	
	void start(String[] args) throws Exception
	{
        DBConnection dbc = new DBConnection();
        mService = new JudokaService(dbc);

	    run(args);
	}
	
    /**
     * @param resp
     * @param pageNo
     * @param aJudoka passing in judoka means only fillin csjuid
     * @throws IOException
     * @throws SQLException
     */
    protected void parsePage(HtmlPage resp, int pageNo, Judoka aJudoka) throws IOException, SQLException
    {
        System.out.println("pageURL " +  resp.getUrl());
        LOG.warn("pageURL " +  resp.getUrl());
        //resp.getWebResponse().
        HtmlTable table = resp.getHtmlElementById("ctl00_cphMain_GridViewUsers");
        int rowNo = 0;
        
        for (final HtmlTableRow row : table.getRows()) 
        {
            rowNo++;
            if (rowNo == 1) continue; // first line is header
            StyleElement st = row.getStyleElement("background-color"); // LightGreen
            
            System.out.println("Found row, st=" + st); //(st == null ? "-null-" : st.getValue()));
            int cno = 1;
            // na konci tabule je next page jumper, a je v dalsi tabuli (idioti)
            if ((st == null || st.getValue().length() == 0) && (aJudoka == null)) //asi je empty
            {
                DomNodeList<HtmlElement> elemz =  row.getElementsByTagName("a");
                String jehla = "Page$" + (pageNo+1);
                for (HtmlElement he : elemz)
                {
                    if (he.getAttribute("href").contains(jehla))
                    {
                        LOG.warn(" ... tu kliknem! " + he);
                        System.out.println(" ... tu kliknem! " + he);
                        //pageNo++;
                        resp = he.click();
                        parsePage(resp, pageNo+1, null);
                    }
                }
                
                Object x = row.getCell(0).getFirstByXPath("a");
                System.out.println("ende: " + elemz.size() + "; " + x);
            }
            Judoka j = new Zavodnik();
            
            // iterate thru the rows
            for (final HtmlTableCell cell : row.getCells()) {
                System.out.print("   Found cell ("+cno+"): " + cell.asText());
                LOG.warn("   Found cell ("+cno+"): " + cell.asText());
                if (cno== 1 && st.getValue().equalsIgnoreCase("LightGreen"))
                {
                    DomNodeList<HtmlElement> kids = cell.getElementsByTagName("a");
                    if (kids.size() > 0)
                    {
                        String href = kids.get(0).getAttribute("href");
                        /*
                         * <script type="text/javascript">
//<![CDATA[
var theForm = document.forms['aspnetForm'];
if (!theForm) {
    theForm = document.aspnetForm;
}
function __doPostBack(eventTarget, eventArgument) {
    if (!theForm.onsubmit || (theForm.onsubmit() != false)) {
        theForm.__EVENTTARGET.value = eventTarget;
        theForm.__EVENTARGUMENT.value = eventArgument;
        theForm.submit();
    }
}
//]]>
</script>
                         */
                        Page in = kids.get(0).click();
                        java.net.URL url = in.getUrl();
                        System.out.print("; cls = "+in.getClass().getName()+"; url = " + in.getUrl() + "; file = " + url.getFile() + "; path = " + url.getPath() + "; query = " + url.getQuery()); 
                        LOG.warn("; cls = "+in.getClass().getName()+"; url = " + in.getUrl() + "; file = " + url.getFile() + "; path = " + url.getPath() + "; query = " + url.getQuery()); 
                        try {
                             
                            Matcher m = mPattern.matcher(url.getFile());
                            if (m.find())
                            {
                                String csuidstr = m.group(1);
                                int csuid = Integer.valueOf(csuidstr);
                                j.setCSJUId(csuid);
                            }
                        } catch (Exception e)
                        {
                            // nop
                        }
                        // must return back
                        switch (1)
                        {
                        case 1:
                            System.out.println("history depth " + resp.getEnclosingWindow().getHistory().getIndex());
                            System.out.println("history depth " + resp.getWebClient().getCurrentWindow().getHistory().getIndex());
                            resp.getEnclosingWindow().getHistory().back();
                            resp.refresh();
                            break;
                        case 2: { // click na cancel 
                            HtmlPage h = (HtmlPage)in;
                            System.out.println("history depth " + resp.getWebClient().getCurrentWindow().getHistory().getIndex());
                            Page pago = h.getForms().get(0).getInputByName("ctl00$cphMain$imgBtnCancel").click();
                            System.out.println("history depth " + resp.getWebClient().getCurrentWindow().getHistory().getIndex());
                            //Page pago = h.getElementById("ctl00_cphMain_imgBtnCancel").click();
                            System.out.println("pago " + pago.getUrl());/**/
                            History hi = in.getEnclosingWindow().getHistory();
                            hi.back();
                            hi.back();
                            //in.getEnclosingWindow().getWebClient().getRefreshHandler().
                            break;
                        }
                        case 3:
                                /*
                                HtmlPage h = (HtmlPage)in;
                                Page pago = h.getForms().get(0).getInputByName("ctl00$cphMain$imgBtnCancel").click();
                                //Page pago = h.getElementById("ctl00_cphMain_imgBtnCancel").click();
                                System.out.println("pago " + pago.getUrl());/**/
                                History hi = in.getEnclosingWindow().getHistory();
                                System.out.println("history depth " + hi.getIndex());
                                //resp.getWebClient().
                                
                                hi.back();
                                hi.go(0);
                                //-in.getEnclosingWindow().getHistory().back();/**/
                                break;
                        }
                        //??resp.getWebClient().getWebWindows().get(0).getHistory().back();
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
                        Calendar cal = Calendar.getInstance();
                        cal.set(year, 0, 1, 0, 0, 0);
                        j.setBirthDate(cal.getTime());
                        break;
                    } catch (Exception e)
                    {
                        
                    }
                }
                System.out.println();
                
                cno++;
            } // end for cells
            if (j.getName() != null) mService.store(j);
        } // end for rows       
    }	
}