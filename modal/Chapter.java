package com.example.enzo.sl_app.modal;

/**
 * Created by enzo on 9/30/2017.
 */

public class Chapter {
    private long mChapterId;/*unique id for chapter*/
    private String mChapterName;/* chapter name */
    private double mChapterWeightage;/*chapter weightage in percentage  */

    public Chapter(long chapterId,String chapterName,double chapterWeightage){
        mChapterId = chapterId;
        mChapterName = chapterName;
        mChapterWeightage = chapterWeightage;
    }

    /*returns new instance of Chapter
    * @params chapterId:long -> changes the mChapterId to chapterId
    * @params chapterName:String-> changes the mChapterName to chapterName
    * @params chapterWeightage:long -> changes the mChapterWeightage to chapterWeightage
    * @returns ->void*/
    public static Chapter newInstance(long chapterId,String chapterName,double chapterWeightage){
        return new Chapter(chapterId,chapterName,chapterWeightage);
    }


    /*returns mChapterId
    *@param ->void
    * @returns ->mChapterId : long*/
    public long getChapterId() {
        return mChapterId;
    }

    /*returns mChapterName
    *@param ->void
    * @returns ->mChapterName : String*/
    public String getChapterName() {
        return mChapterName;
    }

    /*returns mChapterWeighatge
    *@param ->void
    * @returns ->mChapterWeightage : double*/
    public double getChapterWeightage() {
        return mChapterWeightage;
    }

    /*returns mChapterWeighatge in percentage
    *@param ->void
    * @returns ->mChapterWeightage *100 : int */
    public int getChapterWeightagePercentage(){
        return (int)getChapterWeightage()*100;
    }

    /*sets mChapterId
    * @params chapterId:long -> changes the mChapterId to chapterId
    * @returns ->void*/
    public void setChapterId(long chapterId) {
        mChapterId = chapterId;
    }

    /*sets mChapterName
    * @params chapterName:String-> changes the mChapterName to chapterName
    * @returns ->void*/
    public void setChapterName(String chapterName) {
        mChapterName = chapterName;
    }

    /*sets mChapterWeightage
    * @params chapterWeightage:long -> changes the mChapterWeightage to chapterWeightage
    * @returns ->void*/
    public void setChapterWeightage(double chapterWeightage) {
        mChapterWeightage = chapterWeightage;
    }
}
