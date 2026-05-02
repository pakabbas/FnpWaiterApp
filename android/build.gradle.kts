allprojects {
    repositories {
        google()
        mavenCentral()
    }
}

// Play 16 KB: Flutter Android plugins are separate Gradle subprojects; each one
// resolves androidx.datastore on its own classpath. Pinning only in :app can miss
// a plugin still pulling datastore 1.2.x (bad libdatastore_shared_counter.so).
subprojects {
    afterEvaluate {
        configurations.configureEach {
            resolutionStrategy.eachDependency {
                if (requested.group == "androidx.datastore") {
                    useVersion("1.1.1")
                    because("Play 16 KB native lib regression in newer datastore lines")
                }
            }
        }
    }
}

val newBuildDir: Directory =
    rootProject.layout.buildDirectory
        .dir("../../build")
        .get()
rootProject.layout.buildDirectory.value(newBuildDir)

subprojects {
    val newSubprojectBuildDir: Directory = newBuildDir.dir(project.name)
    project.layout.buildDirectory.value(newSubprojectBuildDir)
}
subprojects {
    project.evaluationDependsOn(":app")
}

tasks.register<Delete>("clean") {
    delete(rootProject.layout.buildDirectory)
}

buildscript {
    repositories {
        google()
        mavenCentral()
    }
    dependencies {
        // Add the Google Services plugin for Firebase/Google Sign-In
        classpath("com.google.gms:google-services:4.4.1")
    }
}