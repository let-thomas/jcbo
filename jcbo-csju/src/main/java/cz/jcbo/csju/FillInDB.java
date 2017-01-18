package cz.jcbo.csju;

import java.util.List;

import com.gargoylesoftware.htmlunit.WebClient;
import com.gargoylesoftware.htmlunit.html.HtmlForm;
import com.gargoylesoftware.htmlunit.html.HtmlInput;
import com.gargoylesoftware.htmlunit.html.HtmlPage;

import cz.jcbo.model.Judoka;

public class FillInDB extends Common
{

    public void run(String[] args) throws Exception
    {
        // main page
        try (final WebClient webClient = new WebClient())
        {
            final HtmlPage basePage = webClient.getPage(URL);
            HtmlPage page = basePage;

            List<Judoka> vsichni = mService.listCond("narozen is not null");
            for (Judoka j : vsichni)
            {
                try
                {
                    List<HtmlForm> forms = page.getForms();
                    // Assert.assertTrue(forms.size() > 0);
                    HtmlForm form = forms.get(0);
                    HtmlInput klub = form.getInputByName("ctl00$cphMain$txtClub"); // id = ctl00_cphMain_txtClub
                    klub.setValueAttribute("1. Judo Club Baník Ostrava"); // 1. Judo Club Baník Ostrava
                    klub = form.getInputByName("ctl00$cphMain$hiddenClubId"); // id = ctl00_cphMain_hiddenClubId
                    klub.setValueAttribute("694");
                    HtmlInput inp = form.getInputByName("ctl00$cphMain$txtLastNameFrom");
                    inp.setValueAttribute(j.getSurname());
                    inp = form.getInputByName("ctl00$cphMain$txtLastNameTo");
                    inp.setValueAttribute(j.getSurname());
                    page = form.getInputByName("ctl00$cphMain$imgBtnRefresh").click();
                    
                    parsePage(page, 1, j);
                }
                catch (Exception e)
                {
                    System.out.println(String.format("skipped %s %s due to %d", j.getName(), j.getSurname(), e.toString()));
                    e.printStackTrace();
                }

            }
        }
    }

    public static void main(String[] args) throws Exception
    {
        new FillInDB().start(args);
    }

}
