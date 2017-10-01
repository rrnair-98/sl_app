package com.creeps.sl_app.core_services.modal;

import com.google.gson.annotations.SerializedName;

import java.util.ArrayList;

/**
 * Created by enzo on 9/30/2017.
 */

public class Semester {
    @SerializedName("semester_id")
    private long mSemesterId;/*unique id for the semester*/
    @SerializedName("semester_name")
    private String mSemesterName;/*name of the semester*/
    public Semester(long semesterId,String semesterName){
        mSemesterId = semesterId;
        mSemesterName = semesterName;
    }
    /*returns new instance of Semester
    * @params semesterId:long -> changes the mSemesterId to semesterId
    * @params semesterName:String-> changes the mSemesterName to semesterName
    * @returns ->void*/
    public static Semester newInstance(long semesterId,String semesterName ){
        return  new Semester(semesterId,semesterName);
    }

    /*sets mSemesterId
    * @params semesterId:long -> changes the mSemesterId to semesterId
    * @returns ->void*/
    public void setSemesterId(long semesterId) {
        mSemesterId = semesterId;
    }

    /*sets mSemesterName
    * @params semesterName:String -> changes the mSemesterName to semesterName
    * @returns ->void*/
    public void setSemesterName(String semesterName) {
        mSemesterName = semesterName;
    }

    /*returns mSemesterId
    * @params -> void
    * @returns ->semesterId:long */
    public long getSemesterId() {

        return mSemesterId;
    }

    /*returns mSemesterName
    * @params -> void
    * @returns ->semesterName:String*/
    public String getSemesterName() {
        return mSemesterName;
    }
}
