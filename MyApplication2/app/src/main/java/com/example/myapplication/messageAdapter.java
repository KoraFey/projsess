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
        View view = convertView;
        if (view == null) {
            LayoutInflater layoutInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            view = layoutInflater.inflate(this.ressource, parent, false);
        }

        final Message1 message = list[position];

        if(message != null){
            TextView content = view.findViewById(R.id.message);
            TextView username = view.findViewById(R.id.sendUser);

            content.setText(message.getMessage());
            username.setText(message.getUsername());



        }
        return view;

    }
}
