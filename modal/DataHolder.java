package com.creeps.sl_app.core_services.modal;

import android.content.Context;

/**
 * Created by enzo on 10/1/2017.
 */

/*
* this class encapsulates and provides methods for accessing all the model objects */
public class DataHolder {
    /*context reference */
    private static Context mContext = null;
    /*reference to the student object*/
    private Student mStudent;
    /*reference to singleton object*/
    private static DataHolder mDataHolder = null;
    private DataHolder(){}

    public static DataHolder getInstance(Context context){
        if(mDataHolder == null){
            mContext = context;
            mDataHolder = new DataHolder();
            //set mStudent here
        }
        return mDataHolder;
    }

    /*
    * returns a reference of mStudent
    * @param ->void
    * @return mStudent : Student ->reference to the student object*/
    public Student getStudent() {
        return mStudent;
    }

    /*
    * sets a reference of mStudent
    * @param student:Student->sets mStudent to student
    * @return ->void*/
    public void setStudent(Student student) {
        mStudent = student;
    }
}
