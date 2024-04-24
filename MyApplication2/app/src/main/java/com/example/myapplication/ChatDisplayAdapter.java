package com.example.myapplication;

import android.content.Context;
import android.os.Build;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.DrawableRes;
import androidx.annotation.NonNull;
import androidx.annotation.RequiresApi;

import com.squareup.picasso.Picasso;

import java.util.List;

public class ChatDisplayAdapter extends ArrayAdapter<ChatRoomDisplay> {
    private ChatRoomDisplay[] list;
    private int ressource;
    private Context context;
    public ChatDisplayAdapter(@NonNull Context context, int resource,@NonNull ChatRoomDisplay[] list) {
        super(context, resource,list);
        this.context=context;
        this.list=list;
        this.ressource=resource;
    }

    @Override
    public int getCount(){
        return list.length;
    }

    @RequiresApi(api = Build.VERSION_CODES.O)
    public View getView(int position, View convertView, ViewGroup parent){
        View view=convertView;
        if(view==null){
            LayoutInflater layoutInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            view=layoutInflater.inflate(this.ressource,parent,false);
        }

        final ChatRoomDisplay display = this.list[position];

        if(display != null){
            TextView titre = view.findViewById(R.id.displaytitre);
            ImageView icone = view.findViewById(R.id.imageChatRoom);
            Picasso.get().load(display.getUrl_icone()).placeholder(R.drawable.ic_info).into(icone);
            titre.setText(display.getName());



        }
        return view;

    }


}
