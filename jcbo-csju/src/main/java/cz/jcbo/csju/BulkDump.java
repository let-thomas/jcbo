package cz.jcbo.csju;

import java.util.List;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;

import com.gargoylesoftware.htmlunit.WebClient;
import com.gargoylesoftware.htmlunit.html.HtmlForm;
import com.gargoylesoftware.htmlunit.html.HtmlInput;
import com.gargoylesoftware.htmlunit.html.HtmlPage;


/**
 * Hello world!
 *
 */
public class BulkDump extends Common 
{
    private static final Log LOG = LogFactory.getLog(BulkDump.class);


	public void run( String[] args ) throws Exception
	{
		System.out.println( "Import start!" );
		//final WebClient webClient = new WebClient();
	    try (final WebClient webClient = new WebClient()) 
	    {
	    	
	    	// main page
	        final HtmlPage page = webClient.getPage(URL);
	        //Assert.assertEquals("HtmlUnit - Welcome to HtmlUnit", page.getTitleText()); // nema title

	        // select 1jcbo only
	        List<HtmlForm> forms = page.getForms();
	        //Assert.assertTrue(forms.size() > 0);
	        HtmlForm form = forms.get(0);
	        HtmlInput klub = form.getInputByName("ctl00$cphMain$txtClub"); // id = ctl00_cphMain_txtClub
	        klub.setValueAttribute("1. Judo Club Baník Ostrava"); // 1. Judo Club Baník Ostrava
	        klub = form.getInputByName("ctl00$cphMain$hiddenClubId"); // id = ctl00_cphMain_hiddenClubId
	        klub.setValueAttribute("694");
	        
	        // result page
	        int pageNo = 1;
	        System.out.println("history depth " + webClient.getCurrentWindow().getHistory().getIndex());
	        HtmlPage resp = form.getInputByName("ctl00$cphMain$imgBtnRefresh").click();
            System.out.println("history depth " + webClient.getCurrentWindow().getHistory().getIndex());
	        parsePage(resp, pageNo, null);
	    }
	}
	//judoka
	
    public static void main( String[] args ) throws Exception
    {
        //System.getProperties().put("org.apache.commons.logging.simplelog.defaultlog", "debug");
        System.getProperties().put("java.util.logging.config.file", "/home/mikentom/git/jcbo/jcbo-csju/commons-logging.properties");
        new BulkDump().start(args);
    }
}
