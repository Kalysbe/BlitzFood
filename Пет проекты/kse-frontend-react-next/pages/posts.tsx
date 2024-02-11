import Head from "next/head"

import { MainLayout } from "../layout/MainLayout"

export default function Posts() {
    return(
        <MainLayout>
        <Head>
            <title>Post Page</title>
        </Head>
        <h1 className="ml-9">post</h1>
        
        </MainLayout>
    )
}