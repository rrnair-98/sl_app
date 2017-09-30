package com.example.enzo.sl_app.modal;

import java.lang.reflect.Array;
import java.util.ArrayList;

/**
 * Created by enzo on 9/30/2017.
 */

public class Subject {
    private long mSubjectId;/*unique id given to subject*/
    private String mSubjectName;/*subject name*/
    private ArrayList<Chapter> mChapters;/*list of all chapters in the sibject */

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

    /*returns the mSubjectId
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
}
