package com.creeps.sl_app.quizapp.modal;

/**
 * Created by ADMIN-PC on 22-12-2017.
 */

import com.google.gson.annotations.SerializedName;

import java.lang.reflect.Array;
import java.util.ArrayList;

/**
 * Created by enzo on 9/30/2017.
 */

public class Subject {
    @SerializedName("subject_id")
    private long mSubjectId;/*unique id given to subject*/
    @SerializedName("subject_name")
    private String mSubjectName;/*subject name*/
    @SerializedName("chapters")
    private ArrayList<Chapter> mChapters;/*list of all chapters in the subject */
    @SerializedName("subject_semester_id")
    private long mSubjectSemesterId;/*semester id to which this subject belongs to*/

    public Subject(long subjectId,String subjectName,ArrayList<Chapter> chapters){
        mSubjectId = subjectId;
        mSubjectName = subjectName;
        mChapters = chapters;
    }

    /*returns new instance of Subject
    * @params subjectId:long -> changes the mSubjectId to subjectId
    * @params subjectName:String-> changes the mSubjectName to subjectName
    * @params chapters: ArrayList<Chapter>-> changes the mSChapters to chapters
    * @returns ->void*/
    public static Subject newInstance(long subjectId,String subjectName,ArrayList<Chapter> chapters){
        return new Subject(subjectId,subjectName,chapters);
    }

    /*changes the mChapters
    * @params chapters: ArrayList<Chapter>-> changes the mSChapters to chapters
    * @return ->void
    * */
    public ArrayList<Chapter> getChapters() {
        return mChapters;
    }

    /*changes the mSubjectId
    * @param subjectId: long -> sets mSubjectId to subjectId
    * @return ->void
    * */

    public void setSubjectId(long subjectId) {
        mSubjectId = subjectId;
    }

    /*changes the mSubjectSemesterId
    * @param subjectSemesterId: long -> sets mSubjectSemesterId to subjectSemesterId
    * @return ->void
    * */
    public void setSubjectSemesterId(long subjectSemesterId) {
        mSubjectSemesterId = subjectSemesterId;
    }

    /*changes the mSubjectName
        * @param subjectName: long -> sets mSubjectName to subjectName
        * @return ->void
        * */
    public void setSubjectName(String subjectName) {
        mSubjectName = subjectName;
    }

    /*returns the mSubjectId
    * @param -> void
    * @return ->subjectId: long
    * */
    public long getSubjectId() {

        return mSubjectId;
    }

    /*returns the mSubjectName
    * @param -> void
    * @return ->subjectName: String
    * */
    public String getSubjectName() {
        return mSubjectName;
    }

    /*returns the mChapters
    * @param -> void
    * @return ->mChapters: ArrayList<Chapter>
    * */
    public void setChapters(ArrayList<Chapter> chapters) {
        mChapters = chapters;
    }

    /*returns the mSubjectSemesterId
    * @param -> void
    * @return ->mSubjectSemesterId: long
    * */
    public long getSubjectSemesterId() {
        return mSubjectSemesterId;
    }
}