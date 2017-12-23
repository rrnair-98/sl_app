package com.creeps.sl_app.quizapp.modal;

/**
 * Created by ADMIN-PC on 22-12-2017.
 */

import com.google.gson.annotations.SerializedName;

import java.util.ArrayList;

/**
 * Created by enzo on 9/30/2017.
 */

public class Student {
    @SerializedName("user_id")
    private long mStudentId; /*unique id given to student in database*/
    @SerializedName("name")
    private String mStudentName; /*name of the student*/
    @SerializedName("email")
    private String mStudentEmail;/*email of the student */
    @SerializedName("branch")
    private Branch mStudentBranch; /*branch information of the student*/
    @SerializedName("semester")
    private Semester mStudentSemester; /*semester information of the student*/
    @SerializedName("subjects")
    private ArrayList<Subject> mStudentSubjects;/*subjects the student has entolled for */

    public Student(long studentId,String studentName){
        mStudentId = studentId;
        mStudentName = studentName;
    }

    /*returns new instance of Student class
        * @param studentId:long ->sets mStudentId
        * @param studentName:long ->sets mStudentName
        * */
    public static Student newInstance(long studentId,String studentName){
        return new Student(studentId,studentName);
    }

    /*returns mStudentId
    * @param ->void
    * @return -> mStudentId : long
    * */
    public long getStudentId() {
        return mStudentId;
    }
    /*returns mStudentName
    * @param ->void
    * @return : mStudentName : String
    * */
    public String getStudentName() {
        return mStudentName;
    }

    /*returns mStudentBranch
    * @param ->void
    * @return : mStudentBranch : Branch
    * */
    public Branch getStudentBranch() {
        return mStudentBranch;
    }

    /*returns mStudentSemester
    * @param ->void
    * @return : mStudentSemester: Semester
    * */
    public Semester getStudentSemester() {
        return mStudentSemester;
    }

    /*returns mStudentSubjects
    * @param ->void
    * @return : mStudentSubjects : ArrayList<Subject>
    * */
    public ArrayList<Subject> getStudentSubjects() {
        return mStudentSubjects;
    }

    /*returns mStudentSubjects
    * @param ->void
    * @return : mStudentEmail : String
    * */
    public String getStudentEmail() {
        return mStudentEmail;
    }


    /*sets mStudentId
    * @params studentId:long -> changes the mStudentId to studentId
    * @returns ->void*/
    public void setStudentId(long studentId) {
        mStudentId = studentId;
    }

    /*sets mStudentName
    * @params studentName:String-> changes the mStudentName to studentName
    * @returns ->void*/
    public void setStudentName(String studentName) {
        mStudentName = studentName;
    }

    /*sets mStudentEmail
    * @params studentEmail:String-> changes the mStudentEmail to studentEmail
    * @returns ->void*/
    public void setStudentEmail(String studentEmail) {
        mStudentEmail = studentEmail;
    }

    /*sets mStudentBranch
    * @params studentBranch:Branch -> changes the mStudentBranch to studentBranch
    * @returns ->void*/
    public void setStudentBranch(Branch studentBranch) {
        mStudentBranch = studentBranch;
    }

    /*sets mStudentSemester
    * @params studentSemester:Semester-> changes the mStudentSemester to studentSemester
    * @returns ->void*/
    public void setStudentSemester(Semester studentSemester) {
        mStudentSemester = studentSemester;
    }

    /*sets mStudentSubjects
    * @params studentSubject:ArrayList<Subject>-> changes the mStudentSubjects to studentSubjects
    * @returns ->void*/
    public void setStudentSubjects(ArrayList<Subject> studentSubjects) {
        mStudentSubjects = studentSubjects;
    }
}