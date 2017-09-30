package com.example.enzo.sl_app.modal;

import com.google.gson.annotations.SerializedName;

import java.util.ArrayList;

/**
 * Created by enzo on 9/30/2017.
 */

public class Student {
    private long mStudentId; /*unique id given to student in database*/
    private String mStudentName; /*name of the student*/
    private Branch mStudentBranch; /*branch information of the student*/
    private Semester mStudentSemester; /*semester information of the student*/
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
}
