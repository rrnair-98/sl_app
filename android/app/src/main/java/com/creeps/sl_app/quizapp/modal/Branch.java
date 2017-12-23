package com.creeps.sl_app.quizapp.modal;

/**
 * Created by ADMIN-PC on 22-12-2017.
 */

import com.google.gson.annotations.SerializedName;

/**
 * Created by enzo on 9/30/2017.
 */

public class Branch {
    @SerializedName("branch_id")
    private long mBranchId;//unique id given to the branch
    @SerializedName("branch_name")
    private String mBranchName;// name of the branch

    public Branch(long branchId, String branchName){
        mBranchId  = branchId;
        mBranchName = branchName;
    }

    /*returns new instance of Branch
    * @params branchId:long -> changes the mBranchId to branchId
    * @params branchName:String-> changes the mBranchName to branchName
    * @returns ->void*/
    public static Branch newInstance(long branchId,String branchName){
        return new Branch(branchId,branchName);
    }

    /*returns mBranchId
    * @params ->void
    * @returns ->branchId:long */
    public long getBranchId() {
        return mBranchId;
    }

    /*returns mBranchName
    * @params ->void
    * @returns ->branchName:String*/
    public String getBranchName() {
        return mBranchName;
    }

    /*sets  the mBranchId
    * @params branchId:long -> changes the mBranchId to branchId
    * @returns ->void*/
    public void setBranchId(long branchId) {
        mBranchId = branchId;
    }


    /*sets the mBranchName
    * @params branchName:String-> changes the mBranchName to branchName
    * @returns ->void*/
    public void setBranchName(String branchName) {
        mBranchName = branchName;
    }
}