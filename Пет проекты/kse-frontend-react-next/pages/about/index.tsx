import React from "react";
import Router from "next/router";
import { MainLayout } from "../../layout/MainLayout";

export default function About() {

    const linkClickHandler = () => {
        Router.push('/')
    }
    
    return (
        <MainLayout>
            <h1>About Page</h1>
            <button onClick={linkClickHandler}>Go back to home</button>
            <button onClick={() => Router.push('/posts')}>Posts</button>
        </MainLayout>
    )
}