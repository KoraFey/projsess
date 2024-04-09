package com.example.myapplication;

import android.content.Context;
import android.os.Build;
import android.os.Message;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Adapter;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.RequiresApi;

public class messageAdapter extends ArrayAdapter<Message1> {

    private final int VIEW_TYPE_LAYOUT_ONE = 0;
    private final int VIEW_TYPE_LAYOUT_TWO = 1;
    private Message1[] list;

    private Context context;
    private int ressource;


    public messageAdapter(@NonNull Context context, int resource, @NonNull Message1[] list) {
        super(context, resource, list);
        this.list = list;
        this.ressource=resource;
        this.context = context;
    }

    @Override
    public int getCount() {
        return list.length;
    }

    @RequiresApi(api = Build.VERSION_CODES.O)
    public View getView(int position, View convertView, ViewGroup parent) {
        final Message1 message = list[position];
        View view = convertView;
        if (view == null) {
            if(list[position].isSent()) {
                LayoutInflater layoutInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
                view = layoutInflater.inflate(R.layout.message, parent, false);
            }
            else{
                LayoutInflater layoutInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
                view = layoutInflater.inflate(R.layout.message2, parent, false);
            }
        }


        if(message != null){
            TextView content = view.findViewById(R.id.message);
            TextView username = view.findViewById(R.id.sendUser);

            content.setText(message.getMessage());
            username.setText(message.getUsername());



        }
        return view;

    }



    @Override
    public int getViewTypeCount() {
        return 2;
    }


    @Override
    public int getItemViewType(int position) {
        if(list[position].isSent()){
            return VIEW_TYPE_LAYOUT_ONE;
        }
        else{
            return VIEW_TYPE_LAYOUT_TWO;
        }

    }
}
