package com.example.enzo.sl_app.modal;

/**
 * Created by enzo on 9/30/2017.
 */

public class Branch {
    private long mBranchId;//unique id given to the branch
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
