package cz.jcbo.model.test;

import static org.junit.Assert.*;

import java.util.Calendar;

import javax.annotation.Resource;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Persistence;
import javax.persistence.PersistenceContext;
import javax.transaction.SystemException;
import javax.transaction.UserTransaction;

import org.junit.Test;

import cz.jcbo.model.Judoka;

public class JPATest {
	@PersistenceContext
	EntityManagerFactory emf;
	EntityManager em;
	@Resource
	UserTransaction utx;

	@Test
	public void test() throws IllegalStateException, SecurityException, SystemException 
	{
		emf = Persistence.createEntityManagerFactory( "jcbo", null );
		em = emf.createEntityManager();
		Judoka j = new Judoka("Jan", "Kobliha", Calendar.getInstance().getTime());
		em = emf.createEntityManager();
		try {
			utx.begin();
			Judoka cust = em.find(Judoka.class, 1215);
			System.out.println(cust);
			em.persist(j);
			//em.
			utx.commit();
		} catch (Exception e) {
			utx.rollback();
		}

	}

}
