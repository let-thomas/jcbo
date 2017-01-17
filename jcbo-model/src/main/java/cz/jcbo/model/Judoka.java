/**
 * 
 */
package cz.jcbo.model;

import java.util.Date;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;
//-?import javax.validation.constraints.NotNull;

/**
 * @author T.Mikenda
 */
//@Data 
@Entity
@Table(name="judoka")
public class Judoka 
{
	private @Id @Column(name="id", columnDefinition="int", precision=5) @GeneratedValue(strategy=GenerationType.IDENTITY) Long mId; // (strategy = GenerationType.AUTO)
	//@XmlElement(name="name")
	//-?@NotNull
	private String mName;
	//@XmlElement(name="surname")
	//-?@NotNull
	private String mSurname;
	//@XmlElement(name="birth-date")
	//@XmlJavaTypeAdapter(DateAdapter.class)
	//-?@NotNull
	private @Column(name="birth") Date mBirthDate;
	
	private String mCSJUId; //-cfg.Ejb3Columns:514 propertyHolder.getOverriddenColumn 
	
	private char mStatus;
	
	public Judoka() {
		super();
	}


	/**
	 * @param name
	 * @param surname
	 * @param birthDate
	 */
	public Judoka(String name, String surname, Date birthDate)
	{
		super();
		mName = name.trim();
		mSurname = surname.trim();
		mBirthDate = birthDate;
	}


	@Override
	public String toString() {
		StringBuilder builder = new StringBuilder();
		builder.append("Judoka [mId=").append(mId).append(", mName=").append(mName).append(", mSurname=")
				.append(mSurname).append(", mBirthDate=").append(mBirthDate).append(", mCSJUId=").append(mCSJUId)
				.append("]");
		return builder.toString();
	}


	public Long getId() {
		return mId;
	}

	public void setId(Long id) {
		mId = id;
	}

	public String getName() {
		return mName;
	}

	public void setName(String name) {
		mName = name;
	}

	public String getSurname() {
		return mSurname;
	}

	public void setSurname(String surname) {
		mSurname = surname;
	}

	public Date getBirthDate() {
		return mBirthDate;
	}

	public void setBirthDate(Date birthDate) {
		mBirthDate = birthDate;
	}
	
	public String getCSJUId() {
		return mCSJUId;
	}

	public void setCSJUId(String cSJUId) {
		mCSJUId = cSJUId;
	}


	public char getStatus() {
		return mStatus;
	}


	public void setStatus(char status) {
		mStatus = status;
	}
}
